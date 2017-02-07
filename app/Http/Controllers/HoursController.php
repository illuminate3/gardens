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
use App\Http\Requests\HoursFormRequest;
use App\Notifications\HoursAdded;

class HoursController extends Controller {
	use PeriodTrait;
	
	public $hour;
	public $user;
	public $email;
	public $showyear;
	public $plot;

	
	
	public function __construct(User $user , Plot $plot, Hours $hour, Request $request, EMail $email)
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
		$this->showyear = $this->getShowYear($request);
		
		$hours = $this->hour->where('user_id','=',\Auth::id())
		->with('gardener')
		->where(\DB::raw('YEAR(servicedate)'),'=', $this->showyear)
		->get();
		
		$fields = ['Date'=>'servicedate','From'=>'starttime','To'=>'endtime','Hours'=>'hours','Details'=>'description','Edit'=>'actions'];
		return view('hours.index', compact('hours','fields','showyear'));
	}

	/**
	 * Show the form for creating a new hour
	 *
	 * @return Response
	 */
	public function create()
	{
		
		if(\Auth::user()->can('manage_hours')) {
			
				$members = User::join('members', 'members.user_id', '=', 'users.id')
				->select('users.id', 'members.firstname','members.lastname')
				->where('members.status', '=', 'full')
				->orderBy('members.lastname', 'asc')
				->get();
  	
		 		
		}else{
			
			$members = Member::where('user_id','=',Auth::id())->with(array( 'plots','plots.managedBy','plots.managedBy.userdetails'))->first();
		}

		return view('hours.create',compact('members'));
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

		// If more than one member has posted hours
		//if(is_array($data['hours']['user'])){
			
			foreach ($data['hours']['user'] as $user_id){
				
				$data['hours']['user_id'] = $user_id;
				$hour = new Hours;
				$hour->servicedate = $data['hours']['servicedate'];
				$hour->starttime = $data['hours']['starttime'];
				$hour->endtime = $data['hours']['endtime'];
				$hour->hours = $data['hours']['hours'];
				$hour->description = $data['hours']['description'];
				$hour->user_id = $data['hours']['user_id'];
				$hour->save();
				
				
				$data['result'] = $this->hour->with('gardener','gardener.userdetails','gardener.plots')->findOrFail([$hour->id]);
				//$this->hour->notify(new HoursAdded($data));
				
				$message = $this->email->sendEmailNotifications($data);
			}
			
		//}

		return redirect()->route('hours.all');
	}

	/**
	 * Display the specified hour.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id,Request $request)
	{
	
	
	
	$year = $request->get('y');
	if ($request->has('m'))
	{
		
		$year = strlen($request->get('m')) <2  ? $year ."-0".$request->get('m') : $year."-".$request->get('m');
		
		
	}
	$hours = $this->hour->where('user_id','=',$id)->where('servicedate','like',$year.'%')->with('gardener')->get();

	$fields = ['Date'=>'servicedate','From'=>'starttime','To'=>'endtime','Hours'=>'hours','Details'=>'description'];
	if (\Auth::user()->hasRole('admin') or $id == Auth::id())
	{
			$fields['Edit'] = 'edit';
	}
		return view('hours.show', compact('hours','fields','year'));
	}

	/**
	 * Show the form for editing the specified hour.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$hour = $this->hour->with('gardener','gardener.userdetails','gardener.plots')->findOrFail($id);
		return view('hours.edit', compact('hour'));
	}

	/**
	 * Update the specified hour in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,HoursFormRequest $request)
	{
		$hour = $this->hour->with('gardener','gardener.userdetails','gardener.plots')->findOrFail($id);

		$data['hours']=$request->all();
		$data['hours'] = $this->updateInput($data['hours']);
		$hour->update($data['hours']);
		$data['result'] = $hour;
		$message = $this->email->sendEmailNotifications($data,'update');

		return redirect()->route('hours.all');
	}

	/**
	 * Remove the specified hour from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$hour = $this->hour->findOrFail($id);
		$hour->destroy($id);

		return redirect()->route('hours.index');
	}
	
	
	public function allHours()
	{
		$this->showyear = $this->getShowYear();
		
		$hours = $this->hour->getAllHours();
		
		$showyear = $this->showyear;
		
		return view('hours.all', compact('hours','showyear'));
		
	}
	
	
	
	
	public function addMultipleHours() {
		if($this->user->can('manage_hours')) {
		
			$members = $this->user->join('members', 'members.user_id', '=', 'users.id')
			->select('users.id', 'members.firstname','members.lastname')
			->where('members.status', '=', 'full')
			->orderBy('members.lastname', 'asc')
			->get();
  	
		 		
		}else{
			
			$members = Member::where('user_id','=',\Auth::id())->with(array( 'plots','plots.managedBy','plots.managedBy.userdetails'))->get();
		}
		
		return view('hours.createmultiple',compact('plot','members'));
		
	}
	
	
	public function multistore(Request $request){
		
		$data = $request->all();

		$element['user_id'] = $data['user'][0];
		$allData['userinfo']= User::whereId($data['user'])->with('member')->first();
		
		$fields = ['servicedate','hours','description'];
		for ($i = 5; $i < 10; $i++){
			if($data['servicedate'][$i] != ''){
				foreach ($fields as $field){
					$element[$field] = $data[$field][$i];
				}
				$date = new \DateTime($data['servicedate'][$i]);
				
				$element['servicedate'] = $date->format('Y-m-d');
				$element['startime'] = $date->format('H:i');
				
				
				// replace this with a FormRequest
				if(! $validator = \Validator::make($element , $this->hour->rules))
				
				{
					return redirect()
					->back()
					->withErrors($validator)
					->withInput();
				}
				
				
				$posting = $this->calculateHours($element);

				$this->hour->create($posting);
				$allData['hours'][] = $posting;
			}
		}
		$this->email->sendEmailNotifications($allData,'multi');
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
	public function plothours()
	{
		
		$hours = $this->plot->getPlotHours();
		$showyear = $this->showyear;
		return view('hours.plot', compact('hours','showyear'));
		
		
	}
	
	
	
	public function matrixshow()
	{
		$hours = $this->plot->getPlotHours();
		$showyear = $this->showyear;
		return view('hours.matrix', compact('hours','showyear'));
		
		
	}
	
	

	
	public function	testemail()
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
	
	/*private  function processEmail($inbound)
	{
		// Make sure its a registered user
		
		$user = $this->isMember($inbound->FromEmail());

		if ($user){
			// Process based on subject
			$allData['userinfo'] = $user;

			$subject = strtolower($inbound->Subject());
			
			switch ($subject)
			{
				case "help":
					
					$this->email->sendEmailNotifications($allData,$template='instructions');
					
				break;
				
				case "total":
				case "totals":
					
					$this->allHoursEmail($inbound,$allData);
					
				break;
				
				case "hours":
					$this->parseEmailHours($inbound,$allData);

				break;
				
				default:
				
					$this->parseEmail($inbound,$allData);
				break;
				
			}
		}
		
		
	}*/
	
	
	private function isMember($email){
		$user = $this->getMember($email);
		return $user;	
	}
	
	
	/*private function parseEmailHours($inbound,$allData)
	{
		
		$plot = $allData['userinfo']->member->plots[0]->id;

		$hours = new PostHour();
		
		$hours->from = $inbound->FromEmail();
		
		$data['userinfo']['email'] = $allData['userinfo']['email'];
		
		$hours->membername = $allData['userinfo']->member->firstname . " " . $allData['userinfo']->member->lastname;
		$hours->user_id = $allData['userinfo']->id;
		if(! $inbound->TextBody())
		{
			$hours->text = $inbound->HtmlBody();
		}else{
			$hours->text = $inbound->TextBody();
		}
		$hours->datePosted = date("Y-m-d h:i:s",strtotime($inbound->Date()));
		
		
		$allData['originalText'] = $hours->text;
		$inputdata = $this->getHoursFromEmail($hours->text);

		// If we can parse the email
		if($inputdata)
		{
			// for each row of data (hours) posted
			
			foreach ($inputdata as $input)
			{
				//$input['plot_id'] = $allData['userinfo']->member->plots[0]->id;
				
				$input = $this->calculateHours($input);
				// If multiple flag (users) has been set reiterate for each plot user
				if($input['multiple'] == '*') {
					$users = $this->getPlotUsers($plot);
					
					while(list($email,$id) = each ($users))
					{
						$input['user_id'] = $id;
						$allData['hours'][] = $input;
						$this->hour->create($input);
						
					}
					
				}else{
					
					$input['user_id'] = $allData['userinfo']->id;
					$allData['hours'][] = $input;
					
					$this->hour->create($input);
				}
			}
			
			$this->email->sendEmailNotifications($allData,'email');
			$this->email->sendEmailNotifications($allData,'confirmemail');				
		
		}else{
			// Case if we can match the user but not parse the email
			
			$this->email->sendEmailNotifications($allData,'noparse');
		}
		
		
		$hours->save();
		
	} */
	public function matrixadd() 
	{
		$inputs = $request->get('plothour');
		
		// Input is organized by plot number ($key)
		while(list($key,$value) =each($inputs))
		{
			// Identify user id of primary plot owner
			$gardener = Plot::with('managedBy')->find($key);
			$primary= $gardener->managedBy[0]->id;
			
			// Arrange input hours into consisten array
			$newHours =array();
			while(list($month, $hour) = each ($value))
			{
				$newHours[$month]=floatval($hour);	
				
			}

			// Calculate current recorded hours by plot
			$hours = $this->plot->getPlotHours(NULL,$key);
			$currentHours = array();
			foreach ($hours as $hour)
			{
				$currentHours[$hour->month] = round($hour->hours,2);
				
			}

			// Idenitfy add changes
			$addHours = array_diff(array_filter($newHours),array_filter($currentHours));
			
			$this->changeHours($addHours,$dir=1,$primary);
			
			// Identify delete changes
			$deleteHours=array_diff(array_filter($currentHours),array_filter($newHours));
			
			$this->changeHours($deleteHours,$dir=-1,$primary);
				
		}

		return redirect()->route('hours.matrix');
	}
	 
	 
	 private function changeHours(array $hours,$dir=1,$primary){
		 if(count($hours) >0)
		 {
			while(list($month,$value) = each ($hours))
				{
					$serviceDate = Carbon::createFromDate(null, $month,'1');
					$hourRecord = new Hours;
					$hourRecord->user_id = $primary;
					$hourRecord->servicedate = $serviceDate ;
					$hourRecord->hours = $value *$dir;
					$hourRecord->description = 'Reconcile to spreadsheet';
					$hourRecord->save();
					
				}
			 
			 
		 }
		 
		 
		 
	 }
	/*public function getHoursFromEmail($text)
	{
		$hours=NULL;
		$pattern = "%([0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4})[ ,\t]{0,}(\d+\.?\d{0,2})[ \t]{0,}(\*?)(.?[^\r\n,\;]*)%";
		preg_match_all($pattern, $text, $date);
		$fields = ['full','servicedate','hours','multiple','description'];


		for($n=1;$n<5;$n++){
			$a=0;
			foreach ($date[$n] as $event)
			{
			$a++;
			if($fields[$n] =='servicedate')
			{
				
				$hours[$a][$fields[$n]] = date('Y-m-d 00:00:00',strtotime($event));
			}else{
				$hours[$a][$fields[$n]] =  trim($event);
			}
			}
		}
		
		return $hours;
		
	}*/



	/*private function allHoursEmail($inbound,$allData)
	{

		$plot = $allData['userinfo']->member->plots[0]->id;

		$hours  = $this->getAllDetailHours($plot);

		$allData['year'] = $this->showyear;
		$allData['hours'] = $hours;
		
		$this->email->sendEmailNotifications($allData,'total');
		
	}*/

	/*private function calculateHours($inputdata)
	{
		$data=$inputdata;
		
		// Must have a service date  
		if($inputdata['servicedate'] != '')
		{
			$data['servicedate'] = date('Y-m-d',strtotime($inputdata['servicedate']));
			
			//  Check if the hours field has been completed.
			if($inputdata['hours'] != '' && is_numeric($inputdata['hours'] ))
			{
				$data['hours']=$inputdata['hours'];
				// assume start time is 8:00 am
				if(! isset($inputdata['starttime']) or $inputdata['starttime'] == '')
				{
					$data['starttime'] = date_create($data['servicedate'] . " 08:00:00");
				}else{
					$data['starttime'] = date_create($data['servicedate'] . " " .  $inputdata['starttime']);
					
				}
				
				$data['endtime'] = clone $data['starttime'];
			
				$addminutes = $inputdata['hours'] * 60;

				$data['endtime'] = date_add($data['endtime'], date_interval_create_from_date_string($addminutes. ' minutes'));
	
				$data['starttime'] = $data['starttime']->format('Y-m-d H:i:s');
				$data['endtime'] = $data['endtime']->format('Y-m-d H:i:s');
				 
			}else{
				// Check that starttime has been completed
				if(isset($inputdata['starttime']) && $inputdata['starttime'] != '')
				{
					$data['starttime'] = date_create($data['servicedate'] . " " . $inputdata['starttime']);
					
				}
				// Check that starttime has been completed
				if(isset($inputdata['endtime']) && $inputdata['endtime'] != '')
				{
					$data['endtime'] = date_create($data['servicedate'] . " " . $inputdata['endtime']);
					
				}

				// Calculate hours
				if(isset($data['starttime']) && isset($data['endtime']))
				{

					$duration = $data['starttime']->diff($data['endtime']);
					
					
					$hours = round((($duration->h * 60) + $duration->i)/60,2);
					
					if($hours < 0)
					{
						$hours = 12 - $hours;
					}
					
					$data['hours']= $hours;
					$data['starttime'] = $data['starttime']->format('Y-m-d H:i:s');
					$data['endtime'] = $data['endtime']->format('Y-m-d H:i:s');
				}
		
				
			}
			//* not sure we really need this
			/*if(isset($inputdata['user'])){
				
				// this is actually their user id
				$data['user_id'] = $inputdata['user'][0];
				$member =$this->getUsersMemberId($data['user_id']);
				
				$data['member_id'] = $member[0];
				
				
			}else{
				$data['user_id'] = Auth::id();
				$data['member_id'] =$this->getUsersMemberId($data['user_id']);
				
			}
		}
		return $data;


	}
	*/
	
	
	private function updateInput($data)
	{
		if($data['hours'] != $this->hour->hours) {
			$data = $this->calculateHours($data);
		}else{
			$data['hours']='';
			$data = $this->calculateHours($data);	
			
		}

		return $data;
		
	}
	
	
	// move to User or Member model
	private function  getMember($email)
	{
	
	$user = User::with(array('member','member.plots'))->where('email','=',$email)->first();	
	return $user;	
	}
	
	
	
	 
	 
	 
	 
}
