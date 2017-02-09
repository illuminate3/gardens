<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Email;
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
        $user = $this->user->has('member')->where('email', '=', $emails['from'])->first();
        if (! $user) {
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
        $post = Post::with('comments')->find($id);
        $comment = new Comment;
        $comment->content = $this->getEmailContent($inbound);
        $comment->user_id = $user->id;
        
        $post->comments()->save($comment);
        $content['content'] = $comment->content;
        dd($content);
        $this->forwardMessageToMember($user, $post->toArray(), $content);
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
        $content['content'] = $post->content;
        //send message to all;
        $this->forwardMessageToMember($user, $post->toArray(), $content);
    }

    private function forwardMessageToMember($user, $post, $content)
    {
        Mail::send('emails.message', $content, function ($message) use ($user, $post) {
            $message->to('stephen@crescentcreative.com')
            ->from('gardeners@mcneargardens.com',
                $user->member->firstname." ".$user->member->lastname . " <". $user->email.">")
            ->subject($post['title']. " [id=".$post['id']."]");
        });
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
                //$input['plot_id'] = $allData['userinfo']->member->plots[0]->id;
                
                $input = $this->calculateHours($input);
                // If multiple flag (users) has been set reiterate for each plot user
                if ($input['multiple'] == '*') {
                    $users = $this->getPlotUsers($plot);
                    
                    while (list($email, $id) = each($users)) {
                        $input['user_id'] = $id;
                        $allData['hours'][] = $input;
                        $this->hours->create($input);
                    }
                } else {
                    $input['user_id'] = $allData['userinfo']->id;
                    $allData['hours'][] = $input;
                    
                    $this->hours->create($input);
                }
            }
            
            $this->sendEmailNotifications($allData, 'email');
            $this->sendEmailNotifications($allData, 'confirmemail');
        } else {
            // Case if we can match the user but not parse the email
            // Store to the PostHours table and send a note to the
            // admin.
            $posthours = new PostHours;
            $posthours->create($inputdata);
            $this->sendEmailNotifications($allData, 'noparse');
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
            if (isset($inputdata['user'])) {
                
                // this is actually their user id
                $data['user_id'] = $inputdata['user'][0];
                $member =$this->getUsersMemberId($data['user_id']);
                
                $data['member_id'] = $member[0];
            } else {
                $data['user_id'] = Auth::id();
                $data['member_id'] =$this->getUsersMemberId($data['user_id']);
            }
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
                $emailTemplate = 'emails.hours.adminhours';
                $toAddress = $this->getHoursNotificationEmails();
                $subject = 'Multiple New Hours Added';
            break;
            
            case 'confirmemail':
                $emailTemplate = 'emails.hours.confirmemailhours';
                $toAddress =$data['userinfo']->email;
                $subject = 'New Hours Added';
            break;
            
            case 'email':
                
                $emailTemplate = 'emails.hours.adminemailhours';
                $toAddress = $this->getHoursNotificationEmails();
                $subject = 'New Hours Added';
            break;
            
            case 'noparse':
                
                $emailTemplate = 'emails.hours.noparseemailhours';
                $toAddress =$data['userinfo']->email;
                $subject = "Unable to Add Hours";
            break;
            
            
            case 'total':
                $emailTemplate = 'emails.hours.totalhours';
                $toAddress =$data['userinfo']->email;
                $subject = "Your Total Hours";
            
            
            break;
            
            
            case 'instructions':
            
                $toAddress =$data['userinfo']->email;
                $emailTemplate = 'emails.hours.help';
                $subject= 'Instructions';
                    
            
            break;
        
            default:
                    $emailTemplate = 'emails.hours.adminhours';
                    
                    $toAddress = $this->getHoursNotificationEmails();
                    $subject = 'New Hours Added';
            break;
        }
        
        \Mail::send($emailTemplate, $data, function ($message) use ($toAddress, $subject) {
            $message->to($toAddress)->subject($subject);
        });
    }
    private function getHoursNotificationEmails()
    {
        $roles = Permission::find(9)->roles()->pluck('name');
        
        if (! \App::environment('local')) {
            $hoursManagers = Role::whereIn('name', $roles)->with('users')->get();
            $email = '';
            foreach ($hoursManagers as $user) {
                $email .= $user->users[0]->email . ",";
            }
        } else {
            $email = \Auth::user()->email;
        }
        $email = rtrim($email, ",");
        $emailArray = explode(",", $email);
        return $emailArray;
    }
    private function getPlotUsers($plot_id)
    {
        $users = User::whereHas('plots', function ($q) use ($plot_id) {
            $q->where('plots.id', '=', $plot_id);
        })->pluck('id', 'email');
         
        return $users;
    }
}
