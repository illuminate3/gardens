<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Email;
use App\Plot;
use App\Post;
use App\Comment;
use App\Mail\ConfirmEmailHours;
use App\Mail\NotifyHours;
use App\Mail\NotifyEmailHours;
use App\Mail\EmailMessage;
use App\Mail\TotalHours;
use App\Mail\AdminNoParse;
use App\Mail\NoParse;
use App\Mail\Instructions;
use App\Mail\AdminHours;
use App\Mail\SummaryHoursEmail;
use Illuminate\Http\Request;
use App\PeriodTrait;

class Email extends Model
{
    use PeriodTrait;

    protected $fillable = [];
    public $user;
    public $hours;
    public $showyear;
    
    /**
     * Display a listing of the resource.
     * GET /emailcontroller
     *
     * @return Response
     */
    public function __construct(User $user, Hours $hours, Request $request)
    {
        $this->user = $user;
        $this->hours = $hours;
        $this->showyear = $this->getShowYear($request);
    }
    
    public function processEmail($inbound)
    {
        $emails = $this->findEmailToAddress($inbound);
        $user = $this->user->has('member')
            ->with('member','member.plots','member.plots.managedBy')
            ->where('email', '=', $emails['from'])
            ->first();
        
        if (! $user) {
            // think about sending a notiication to the admin
            dd('Phony');
        }

        switch ($emails['to']) {
            case 'gardeners@mcneargardens.com':
            
                $this->processMessageEmail($inbound, $user);
            break;

            case 'hours@mcneargardens.com':

                $this->processHoursEmail($inbound, $user);
            break;
        }
    }


    private function findEmailToAddress($inbound)
    {
        $from = $inbound->ToFull();
        $emails['to'] = $from[0]->Email;
        $emails['from'] = $inbound->FromEmail();
        return $emails;
    }


    private function processMessageEmail($inbound, $user)
    {
        //check to see if this is a reply
        //
        if (preg_match('/\N\[id=(?<id>\d*)\]/', $inbound->Subject(), $regs)) {
            $id = $regs['id'];

            $this->createNewComment($inbound, $user, $id);
            return;
        } else {
            $this->createNewPost($inbound, $user);
        }
    }


    private function createNewComment($inbound, $user, $id)
    {
        $post = Post::with('comments','author','author.member','comments.author','comments.author.member')->find($id);
        $comment = new Comment;
        $comment->content = $this->getEmailContent($inbound);
        $comment->user_id = $user->id;
        
        $post->comments()->save($comment);
        
        $this->forwardMessageToMember($user, $post, $comment);
    }

    private function createNewPost($inbound, $user)
    {
        $slug = preg_replace("/[^A-Za-z0-9 ]/", '', $inbound->Subject());
        $slug = str_replace(" ", "_", $slug);
        $slug = strtolower($slug) . mt_rand();
        
        $post = new Post;
        $post->title = $inbound->Subject();
        $post->slug = $slug;
        $post->content = $this->getEmailContent($inbound);
        $post->user_id = $user->id;
        $post->save();
        
        //send message to all;
        $this->forwardMessageToMember($user, $post);
    }

    private function forwardMessageToMember($user, $post, $comment=null)
    {
      
        \Mail::to('stephen@crescentcreative.com')->queue(new EmailMessage($user,$post,$comment));
            
        /*Mail::send('emails.message', $content, function ($message) use ($user, $post) {
            $message->to('stephen@crescentcreative.com')
            ->from('gardeners@mcneargardens.com',
                $user->member->firstname." ".$user->member->lastname . " <". $user->email.">")
            ->subject($post['title']. " [id=".$post['id']."]");
        });*/
    }

    private function getEmailContent($inbound)
    {
        if ($inbound->StrippedTextReply()) {
            $content = $inbound->StrippedTextReply();
        } elseif ($inbound->TextBody()) {
            $content = $inbound->TextBody();
        } else {
            $content = $inbound->HtmlBody();
        }
        
        return $content;
    }


    private function processHoursEmail($inbound, $user)
    {
        if ($user) {

            // Process based on subject
            $allData['userinfo'] = $user;

            $subject = strtolower($inbound->Subject());

            switch ($subject) {
                case "help":
                    
                    $this->sendEmailNotifications($allData, $template='instructions');
                    
                break;
                
                case "total":
                case "totals":
                    
                    $this->allHoursEmail($inbound, $allData);
                    
                break;
                
                case "hours":
                    $this->parseEmailHours($inbound, $allData);

                break;
                
                default:
                
                    $this->parseEmailHours($inbound, $allData);
                break;
                
            }
        }
    }
    
    
    
    private function allHoursEmail($inbound, $allData)
    {
        $plot = $allData['userinfo']->member->plots[0]->id;

        $hours  = $this->hours->getAllDetailHours($plot);

        $allData['year'] = $this->showyear;
        $allData['hours'] = $hours;
        
        $this->sendEmailNotifications($allData, 'total');
    }
    
    private function parseEmailHours($inbound, $allData)
    {
        $plot = $allData['userinfo']->member->plots[0]->id;
        
        $this->hours->from = $inbound->FromEmail();
        
        $data['userinfo']['email'] = $allData['userinfo']['email'];
        
        $this->hours->membername = $allData['userinfo']->member->firstname . " " . $allData['userinfo']->member->lastname;
        $this->hours->user_id = $allData['userinfo']->id;
        
        $this->hours->text = $this->getEmailContent($inbound);
        
        $this->hours->datePosted = date("Y-m-d h:i:s", strtotime($inbound->Date()));
        
        
        $allData['originalText'] = $this->hours->text;
        
        $inputdata = $this->getHoursFromEmail($this->hours->text);

        // If we can parse the email
        if ($inputdata) {
            // for each row of data (hours) posted
            
            foreach ($inputdata as $input) {

                $plot = $allData['userinfo']->member->plots[0]->id;
               
                $input = $this->calculateHours($input);
                
                // If multiple flag (users) has been set reiterate for each plot user
                if ($input['multiple'] == '*') {
                    $users = $this->getPlotUsers($plot);
                    
                    foreach ($users as $id=>$email) {
                        $input['user_id']=$id;
                        $hours = new Hours;
                        $hours->fill($input);
                        $hours->save();
                    }
                } else {
                    $input['user_id'] = $allData['userinfo']->id;
                    $allData['hours'][] = $input;
                    $hours = new Hours;
                    $hours->fill($input);
                    $hours->save();

                }
               
            }
            
            $this->sendEmailNotifications($allData, 'email');

            $this->sendEmailNotifications($allData, 'confirmemail');
        } else {
            // Case if we can match the user but not parse the email
            // Store to the PostHours table and send a note to the
            // admin.
           // $posthours = new PostHours;
           // $posthours->create($inputdata);
            $this->sendEmailNotifications($allData, 'noparse');

            $this->sendEmailNotifications($allData, 'adminnoparse');
        }
    }

    private function getHoursFromEmail($text)
    {
        $hours=null;
        $pattern = "%([0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4})[ ,\t]{0,}(\d+\.?\d{0,2})[ \t]{0,}(\*?)(.?[^(\r?\n),\;]*)%";

        preg_match_all($pattern, $text, $date);
    
        $fields = ['full','servicedate','hours','multiple','description'];


        for ($n=1;$n<5;$n++) {
            $a=0;
            foreach ($date[$n] as $event) {
                $a++;
                if ($fields[$n] =='servicedate') {
                    $hours[$a][$fields[$n]] = date('Y-m-d 00:00:00', strtotime($event));
                } else {
                    $hours[$a][$fields[$n]] =  trim($event);
                }
            }
        }
        
        return $hours;
    }
    private function calculateHours($inputdata)
    {
        $data=$inputdata;
        
        // Must have a service date
        if ($inputdata['servicedate'] != '') {
            $data['servicedate'] = date('Y-m-d', strtotime($inputdata['servicedate']));
            
            //  Check if the hours field has been completed.
            if ($inputdata['hours'] != '' && is_numeric($inputdata['hours'])) {
                $data['hours']=$inputdata['hours'];
                // assume start time is 8:00 am
                if (! isset($inputdata['starttime']) or $inputdata['starttime'] == '') {
                    $data['starttime'] = date_create($data['servicedate'] . " 08:00:00");
                } else {
                    $data['starttime'] = date_create($data['servicedate'] . " " .  $inputdata['starttime']);
                }
                
                $data['endtime'] = clone $data['starttime'];
            
                $addminutes = $inputdata['hours'] * 60;

                $data['endtime'] = date_add($data['endtime'], date_interval_create_from_date_string($addminutes. ' minutes'));
    
                $data['starttime'] = $data['starttime']->format('Y-m-d H:i:s');
                $data['endtime'] = $data['endtime']->format('Y-m-d H:i:s');
            } else {
                // Check that starttime has been completed
                if (isset($inputdata['starttime']) && $inputdata['starttime'] != '') {
                    $data['starttime'] = date_create($data['servicedate'] . " " . $inputdata['starttime']);
                }
                // Check that starttime has been completed
                if (isset($inputdata['endtime']) && $inputdata['endtime'] != '') {
                    $data['endtime'] = date_create($data['servicedate'] . " " . $inputdata['endtime']);
                }

                // Calculate hours
                if (isset($data['starttime']) && isset($data['endtime'])) {
                    $duration = $data['starttime']->diff($data['endtime']);
                    
                    
                    $hours = round((($duration->h * 60) + $duration->i)/60, 2);
                    
                    if ($hours < 0) {
                        $hours = 12 - $hours;
                    }
                    
                    $data['hours']= $hours;
                    $data['starttime'] = $data['starttime']->format('Y-m-d H:i:s');
                    $data['endtime'] = $data['endtime']->format('Y-m-d H:i:s');
                }
            }
            /*if (isset($inputdata['user'])) {
                
                // this is actually their user id
                $data['user_id'] = $inputdata['user'][0];
                $member =$this->getUsersMemberId($data['user_id']);
                
                $data['member_id'] = $member[0];
            } else {
                $data['user_id'] = \Auth::id();
                $data['member_id'] =$this->getUsersMemberId($data['user_id']);
            }*/
        }
        return $data;
    }

    private function getUsersMemberId($userid)
    {
        $memberid = Member::where('user_id', '=', $userid)->pluck('id');
         
        return $memberid;
    }

    public function sendEmailNotifications($data, $template=null)
    {
        

        switch ($template) {
            case 'multi':
             
                $toAddress = $this->getHoursNotificationEmails();
                \Mail::to($toAddress)->queue(new AdminHours($data));
            break;
            
            case 'confirmemail':
               
                \Mail::to($data['userinfo']->email)->queue(new ConfirmEmailHours($data));
            break;
            
            case 'email':    
                $toAddress = $this->getHoursNotificationEmails();
                \Mail::to($toAddress)->queue(new NotifyEmailHours($data));
            
            break;
            
            case 'noparse':
                
                 \Mail::to($data['userinfo']->email)->queue(new NoParse($data));
            break;

            case 'adminnoparse':
                  $toAddress = $this->getHoursNotificationEmails();
                 \Mail::to($toAddress)->queue(new AdminNoParse($data));
            break;
            
            
            case 'total':
                \Mail::to($data['userinfo']->email)->queue(new TotalHours($data));

            break;
            
            
            case 'instructions':
            
                $toAddress =$data['userinfo']->email;
                \Mail::to($toAddress)->queue(new Instructions($data));
                    
            
            break;
        
            default:
                $toAddress = $this->getHoursNotificationEmails();
                \Mail::to($toAddress)->queue(new AdminHours($data));
            break;
        }

        
    }


    public function getHoursNotificationEmails()
    {
        $roles = Permission::find(9)->roles()->pluck('name');
        
        
            $hoursManagers = Role::whereIn('name', $roles)->with('users')->get();
            $email = '';
            foreach ($hoursManagers as $user) {
                $email .= $user->users[0]->email . ",";
            }
        
        $email = rtrim($email, ",");
        $emailArray = explode(",", $email);

        return $emailArray;
    }

    private function getPlotUsers($plot_id)
    {
    
       $members = Plot::with('managedBy')->where('plots.id', '=', $plot_id)->first();
       $users = array();
       foreach ($members->managedBy as $member)
       {
        $users[$member->userdetails->id]= $member->userdetails->email;
       }
       return $users;
    }
}
