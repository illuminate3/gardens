<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Hours;
use App\Member;
use App\User;
use App\Plot;
use App\Email;
use App\Permission;
use App\PeriodTrait;
use App\Mail\NotifyHours;
use Carbon\Carbon;
use App\Http\Requests\HoursFormRequest;
use App\Notifications\HoursAdded;

class HoursController extends Controller
{
    use PeriodTrait;
    
    public $hour;
    public $user;
    public $email;
    public $showyear;
    public $plot;

    
    
    public function __construct(User $user, Plot $plot, Hours $hour, Request $request, EMail $email)
    {
        $this->hour = $hour;
        $this->user = $user;
        $this->email = $email;
        $this->plot = $plot;
        $this->showyear = $this->getShowYear($request);
    }
    
    /**
     * Display a listing of hours
     *
     * @return Response
     */
    public function index(Request $request)
    {
       
        $servicedate = $this->getShowYear($request);
        $hours = $this->hour->where('user_id', '=', auth()->id())
        ->with('gardener')
        ->where(\DB::raw('YEAR(servicedate)'), '=', $servicedate)
        ->get();
        
        
        return view('hours.index', compact('hours',  'showyear','servicedate'));
    }

    /**
     * Show the form for creating a new hour
     *
     * @return Response
     */
    public function create()
    {
     
        if (auth()->user()->can('manage_hours')) {
            $members = User::join('members', 'members.user_id', '=', 'users.id')
                ->select('users.id', 'members.firstname', 'members.lastname')
                ->where('members.status', '=', 'full')
                ->orderBy('members.lastname', 'asc')
                ->get();
        } else {
            $members = Member::where('user_id', '=', auth()->user()->id)->with( 'plots','plots.managedBy','plots.managedBy.user')->first();
        }

        return view('hours.create', compact('members'));
    }

    /**
     * Store a newly created hour in storage.
     *
     * @return Response
     */
    public function store(HoursFormRequest $request)
    {
       $data['hours'] = $request->all();
       $data['hours'] = $this->hour->calculateHours($data['hours']);
       $data['hours']['trans_id'] = date('U').rand();
     
        // If more than one member has posted hours
        //if(is_array($data['hours']['user'])){
        
            foreach ($data['hours']['user'] as $user_id) {
                $data['gardener'][] = Member::where('user_id','=',$user_id)->first();
                $data['hours']['user_id']= $user_id;
                $hour->create($data['hours']);
                $data['service']=$hour;
                
            }
            $toAddress = $this->email->getHoursNotificationEmails();
           \Mail::to($toAddress)->queue(new NotifyHours($data));


        return redirect()->route('hours.index');
    }

    /**
     * Display the specified hour.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if($request->has('y')){
            $year = $request->get('y');
        }else{
            $year=date('Y');  
        }   
        if ($request->has('m')) {
             $year = strlen($request->get('m')) <2  ? $year ."-0".$request->get('m') : $year."-".$request->get('m');
        }
        $hours = $this->hour->where('user_id', '=', $id)
            ->where('servicedate', 'like', $year.'%')
            ->with('gardener')
            ->get();
        return view('hours.show', compact('hours',  'year','id'));
    }

    /**
     * Show the form for editing the specified hour.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $hour = $this->hour->with('gardener', 'gardener.user', 'gardener.plots')->findOrFail($id);
        
        return view('hours.edit', compact('hour'));
    }

    /**
     * Update the specified hour in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, HoursFormRequest $request)
    {
       $hour = $this->hour->findOrFail($id);
       $data['hours']=$request->all();
       $data['hours'] = $this->hour->calculateHours($data['hours']);
       $hour->update($data['hours']) ;
      return redirect()->route('hours.index');
    }

    /**
     * Remove the specified hour from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->hour->destroy($id);
        
        return redirect()->route('hours.index')->with('message','Hours deleted');
    }
    
    
    public function allHours()
    {
        $this->showyear = $this->getShowYear();
        
        $hours = $this->hour->getAllHours();
        
        $showyear = $this->showyear;
        
        return view('hours.all', compact('hours', 'showyear'));
    }
    
    
    
    
    public function addMultipleHours()
    {
        if ($this->user->can('manage_hours')) {
            $members = $this->user->join('members', 'members.user_id', '=', 'users.id')
            ->select('users.id', 'members.firstname', 'members.lastname')
            ->where('members.status', '=', 'full')
            ->orderBy('members.lastname', 'asc')
            ->get();
        } else {
            $members = Member::where('user_id', '=', \Auth::id())->with(array( 'plots','plots.managedBy','plots.managedBy.user'))->get();
        }
        
        return view('hours.createmultiple', compact('plot', 'members'));
    }
    
    
    public function multistore(Request $request)
    {
        $data = $request->all();

        $element['user_id'] = $data['user'][0];
        $allData['userinfo']= User::whereId($data['user'])->with('member')->first();
        
        $fields = ['servicedate','hours','description'];
        for ($i = 5; $i < 10; $i++) {
            if ($data['servicedate'][$i] != '') {
                foreach ($fields as $field) {
                    $element[$field] = $data[$field][$i];
                }
                $date = new \DateTime($data['servicedate'][$i]);
                
                $element['servicedate'] = $date->format('Y-m-d');
                $element['startime'] = $date->format('H:i');
                
                
                // replace this with a FormRequest
                if (! $validator = \Validator::make($element, $this->hour->rules)) {
                    return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
                }
                
                
                $posting = $this->hour->calculateHours($element);

                $this->hour->create($posting);
                $allData['hours'][] = $posting;
            }
        }
        $this->email->sendEmailNotifications($allData, 'multi');
        return redirect()->route('hours.all');
    }
    public function downloadHours()
    {
        $hours  = $this->getAllDetailHours();
        $this->hours->exportHours($hours);
    }
    /**
     * Show hours by plot.
     *
     * 
     * @return View
     */
    public function plothours(Request $request)
    {
        $hours = $this->plot->getPlotHours('','',$request);
        $showyear = $this->showyear;
        return view('hours.plot', compact('hours', 'showyear'));
    }
    
    
    
    public function matrixshow(Request $request)
    {
        $hours = $this->plot->getPlotHours('', '', $request);
        $showyear = $this->showyear;
        return view('hours.matrix', compact('hours', 'showyear'));
    }
    
        
    public function testemail()
    {
        $inbound = new \Postmark\Inbound(file_get_contents('inbound.json'));
            
        $this->processEmail($inbound);

        echo "<h2>All done!</h2>";
    }
    
    
    public function receiveHoursEmail()
    {
        $inbound = new \Postmark\Inbound(file_get_contents('php://input'));

        $this->processEmail($inbound);
    }
    
        
    private function isMember($email)
    {
        $user = $this->getMember($email);
        return $user;
    }
    
    
    public function matrixadd(Request $request)
    {
        $inputs = $request->get('plothour');
        
        // Input is organized by plot number ($key)
        foreach ($inputs  as $key => $value) {
            
            // Identify user id of primary plot owner
            $gardener = Plot::with('managedBy')->find($key);
            $primary= $gardener->managedBy[0]->user->id;

            
            // Arrange input hours into consisten array
            $newHours =array();
            foreach ($value as $month => $hour) {
                $newHours[$month]=floatval($hour);
            }

            // Calculate current recorded hours by plot
            $hours = $this->plot->getPlotHours(null, $key, $request);
            $currentHours = array();
            foreach ($hours as $hour) {
                $currentHours[$hour->month] = round($hour->hours, 2);
            }

            // Idenitfy add changes
            $addHours = array_diff(array_filter($newHours), array_filter($currentHours));
            
            $this->changeHours($addHours, $dir=1, $primary);
            
            // Identify delete changes
            $deleteHours=array_diff(array_filter($currentHours), array_filter($newHours));
            
            $this->changeHours($deleteHours, $dir=-1, $primary);
        }

        return redirect()->route('hours.matrix');
    }
     
     
    private function changeHours(array $hours, $dir=1, $primary)
    {
        if (count($hours) >0) {
            while (list($month, $value) = each($hours)) {
                $serviceDate = Carbon::createFromDate(null, $month, '1');
                $hourRecord = new Hours;
                $hourRecord->user_id = $primary;
                $hourRecord->servicedate = $serviceDate ;
                $hourRecord->hours = $value *$dir;
                $hourRecord->description = 'Reconcile to spreadsheet';
                $hourRecord->save();
            }
        }
    }
    
    
    
    private function updateInput($data)
    {
        if ($data['hours'] != $this->hour->hours) {
            $data = $this->hour->calculateHours($data);
        } else {
            $data['hours']='';
            $data = $this->hour->calculateHours($data);
        }

        return $data;
    }
    

    private function getMember($email)
    {
        $user = User::with(array('member','member.plots'))->where('email', '=', $email)->first();
        return $user;
    }
}
