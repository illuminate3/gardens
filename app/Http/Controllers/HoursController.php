<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Hours;
use App\Member;
use App\User;
use App\PeriodTrait;

class HoursController extends Controller {
use PeriodTrait;
	
	public $hour;

	
	
	public function __construct(Hours $hour)
	{
		$this->hour = $hour;

		
		
	}
	
	/**
	 * Display a listing of hours
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		
		$this->getShowYear($request);
		$showyear = $this->showyear;
		
		$hours = $this->hour->where('user_id','=',Auth::id())
		->with('gardener')
		->where(\DB::raw('YEAR(servicedate)'),'=', $showyear)
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
		
		if(Auth::user()->can('manage_hours')) {
			
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
	public function store(Request $request)
	{
		$data['hours'] = $request->all();
		
		$data['hours'] = $this->calculateHours($data['hours']);
	
		$validator = Validator::make($data['hours'] , $this->hour->rules);
		$validator->sometimes('hours', 'required', function($input) use ($data)
				{
				   return $data['hours']['starttime'] == NULL;
				});
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		
		// If more than one member has posted hours
		if(is_array($data['hours']['user'])){
			
			foreach ($data['hours']['user'] as $user_id){
				
				$data['hours']['user_id'] = $user_id;
				$this->hour->create($data['hours']);
				$data['userinfo'] = $this->user->with('member')->where('id','=',$data['hours']['user_id'])->first();

				$message = $this->sendEmailNotifications($data);
			}
			
		}

		return Redirect::route('hours.all');
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
	if ($request->get('m') !== null)
	{
		
		$year = strlen($request->get('m')) <2  ? $year ."-0".$request->get('m') : $year."-".$request->get('m');
		
		
	}
	$hours = $this->hour->where('user_id','=',$id)->where('servicedate','like',$year.'%')->with('gardener')->get();

	$fields = ['Date'=>'servicedate','From'=>'starttime','To'=>'endtime','Hours'=>'hours','Details'=>'description'];
	if (Auth::user()->hasRole('admin') or $id == Auth::id())
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
	public function edit($hour)
	{
		
		$plot = $this->getUsersPlot(Auth::id());
		
		return view('hours.edit', compact('hour','plot'));
	}

	/**
	 * Update the specified hour in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($hour,Request $request)
	{

		$data['hours']=$request->all();

		$this->hour = $hour;
		$validator = Validator::make($data['hours'] , $this->hour->rules);
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$data['hours'] = $this->updateInput($data['hours']);
		$data['hours']['user_id'] = Auth::id();
		$data['userinfo'] = User::with('member')->where('id','=',$data['hours']['user_id'])->first();
		

		
		$hour->update($data['hours']);
		$message = $this->sendEmailNotifications($data);

		return Redirect::route('hours.index');
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

		return Redirect::route('hours.index');
	}
	
	
	public function allHours(Request $request)
	{
		
		$hours = $this->getAllHours($request);
		$showyear = $this->showyear;
		
		return view('hours.all', compact('hours','showyear'));
		
	}
	
	
	private function getAllHours(Request $request)
	{
		$this->getShowYear($request);
		
		$query ="SELECT 
					users.id as id, 
					firstname,lastname, 
					YEAR(servicedate) as year,
					MONTH(servicedate) as month, 
					SUM(hours) as hours 
				
				FROM 
					users,
					members,
					hours 
					
				WHERE 
					hours.user_id = users.id
					and members.user_id = users.id 
					and YEAR(servicedate) = '".$this->showyear."' 
				
				GROUP BY 
					id,
					lastname,
					firstname,
					YEAR(servicedate), 
					MONTH(servicedate) 
				
				ORDER BY 
					lastname,
					firstname,
					month,
					year";

		$hours = \DB::select(\DB::raw($query));
		
		return $hours;
	}
	
	public function addMultipleHours() {
			if($this->user->can('manage_hours')) {
		
			$members = $this->user->join('members', 'members.user_id', '=', 'users.id')
			->select('users.id', 'members.firstname','members.lastname')
			->where('members.status', '=', 'full')
			->orderBy('members.lastname', 'asc')
			->get();
  	
		 		
		}else{
			
			$members = Member::where('user_id','=',Auth::id())->with(array( 'plots','plots.managedBy','plots.managedBy.userdetails'))->get();
		}
		
		return view('hours.createmultiple',compact('plot','members'));
		
	}
	
	
	public function multistore(Request $request){
		
		$data = $request->all();

		$element['user'] = $data['user'];
		$allData['userinfo']= User::whereId($data['user'])->with('member')->first();
		
		$fields = ['servicedate','hours','description'];
		for ($i = 5; $i < 10; $i++){
			if($data['servicedate'][$i] != ''){
				foreach ($fields as $field){
					$element[$field] = $data[$field][$i];
				}
				$date = new DateTime($data['servicedate'][$i]);
				
				$element['servicedate'] = $date->format('Y-m-d');
				$element['startime'] = $date->format('H:i');
				
				
				
				$validator = Validator::make($element , $this->hour->rules);
				
				
				
				if ($validator->fails())
				{
					
					return Redirect::back()->withErrors($validator)->withInput();
				}
				$posting = $this->calculateHours($element);
				$this->hour->create($posting);
				$allData['hours'][] = $posting;
			}
		}
			$this->sendEmailNotifications($allData,'email');

		return Redirect::route('hours.all');
		
	}
	public function downloadHours()
	{
		$data  = $this->getAllDetailHours();
		$filename = "attachment; filename=\"hours_export.csv\"";
		$headers = array(
			  'Content-Type' => 'text/csv',
			  'Content-Disposition' => $filename ,
		  );
		$fields = ['servicedate','hours','description','gardener','plot'];
		$output = $this->hour->exportHours($fields,$data);
		return Response::make($output, 200, $headers);
		
		
		
	}
	/**
	 * Calculate start / edn time and hours.
	 *
	 * @param  array  $inputdata
	 * @return Response
	 */
	public function plothours()
	{
		
		$hours = $this->getPlotHours();
		$showyear = $this->showyear;
		return view('hours.plot', compact('hours','showyear'));
		
		
	}
	
	
	
	public function matrixshow()
	{
		$hours = $this->getPlotHours();
		$showyear = $this->showyear;
		return view('hours.matrix', compact('hours','showyear'));
		
		
	}
	
	
	private function getPlotHours($plot = NULL,$id=NULL, Request $request)
	{
		$this->getShowYear($request);
		$showyear = $this->showyear;
		$query ="SELECT 
					plots.id as plotid, 
					type,
					month(servicedate) as month,
					year(servicedate) as year,
					sum(hours.hours) as hours,
					plots.description as plot 
				
				FROM 
					
					members,
					member_plot,
					plots,
					users
				
				LEFT JOIN 
					hours on hours.user_id = users.id and (year(servicedate) IS NULL or year(servicedate) = '".$this->showyear."' )
				
				WHERE 
					
					users.id = members.user_id 
					and members.id = member_plot.member_id 
					and member_plot.plot_id = plots.id";
				
				if($plot)
				{
					$query.=" and plotnumber = ". $plot;
				}
				if($id)
				{
					$query.=" and plots.id = ". $id;
					
				}
				
		
		$query.="
				GROUP BY
					plots.id, year, month
				 ORDER BY 
					plots.description,-month DESC, -year DESC";

		$hours = DB::select(DB::raw($query));

		return $hours;
		
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
	
	private  function processEmail($inbound)
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
					
					$this->sendEmailNotifications($allData,$template='instructions');
					
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
		
		
	}
	
	
	private function isMember($email){
		$user = $this->getMember($email);
		return $user;	
	}
	
	private function parseEmail($inbound,$allData)
	{
		
	}
	private function parseEmailHours($inbound,$allData)
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
			
			$this->sendEmailNotifications($allData,'email');
			$this->sendEmailNotifications($allData,'confirmemail');				
		
		}else{
			// Case if we can match the user but not parse the email
			
			$this->sendEmailNotifications($allData,'noparse');
		}
		
		
		$hours->save();
		
	} 
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
			$hours = $this->getPlotHours(NULL,$key);
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

		return Redirect::route('hours.matrix');
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
	public function getHoursFromEmail($text)
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
		
	}
	private function getAllDetailHours($plot = NULL)
	{
		if($plot)
		{
			// convert plot to users
			
			
			$users = Plot::with('managedBy','managedBy.userdetails')->where('id','=',$plot)->firstOrFail();
			

			foreach ($users->managedBy as $member){
				//dd($member->userdetails->id);
				$user_id[]=  $member->userdetails->id;
				
			
			}

			// get users hours
			$hours = Hours::whereIn('user_id',$user_id)
				->where(DB::raw('YEAR(servicedate)'), '=', $this->showyear)
				->with('gardener')->orderBy('servicedate')
				->get();
			
		}else{
			//$hours = $this->hour->where(DB::raw('YEAR(servicedate)'), '=', $this->showyear)->with('gardener')->orderBy('servicedate')->get();
			//$fields = ['servicedate','hours','description','gardener','plot'];
			$query = "select 
				servicedate,
				hours ,
				concat(members.firstname,' ',members.lastname) as gardener,
					hours.description as description, 
				plots.description as plot
			FROM hours,users,members,member_plot,plots 
			WHERE 
				hours.user_id = users.id 
				and users.id = members.user_id 
				and members.id = member_plot.member_id 
				and member_plot.plot_id = plots.id 
				and YEAR(servicedate) = '". $this->showyear."'
			ORDER BY plotnumber";
			$hours = DB::select(DB::raw($query));
		}
		
		return $hours;
	}


	private function allHoursEmail($inbound,$allData)
	{

		$plot = $allData['userinfo']->member->plots[0]->id;

		$hours  = $this->getAllDetailHours($plot);

		$allData['year'] = $this->showyear;
		$allData['hours'] = $hours;
		
		$this->sendEmailNotifications($allData,'total');
		
	}

	private function calculateHours($inputdata)
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
			if(isset($inputdata['user'])){
				
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
	
	
	
	private function  getMember($email)
	{
	
	$user = User::with(array('member','member.plots'))->where('email','=',$email)->first();	
	return $user;	
	}
	
	
	
	private function sendEmailNotifications($data,$template=NULL)
	{
		switch ($template) {
			case 'multi':
				$emailTemplate = 'emails.hours.adminhours';
				$toAddress = $this->getHoursNotificationEmails();

				$subject = 'New Hours Added';
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
					//$toAddress ='stephen.hamilton@mail.com';
					$toAddress = $this->getHoursNotificationEmails();
					$subject = 'New Hours Added';
			break;
		}
		
		Mail::send($emailTemplate,$data, function($message) use ($toAddress,$subject)
		{
			$message->to($toAddress)->subject($subject);
			
		});
		
		
	}
	 
	 private function getMembersUserId($memberid)
	 {
		 $userid = Member::where('id','=',$memberid)->lists('user_id');
		 
		 return $userid;
		 
	 }
	 
	  private function getUsersMemberId($userid)
	 {
		 $memberid = Member::where('user_id','=',$userid)->lists('id');
		 
		 return $memberid;
		 
	 }
	 
	 
	 private function getUsersPlot($user_id)
	 {
		
		 $plot = Plot::whereHas('managedBy', function($q) use($user_id)
		{
			$q->where('member_plot.user_id', '=', $user_id);
		
		})->first();

		return $plot;	 
	 }
	 
	 private function getHoursNotificationEmails()
	 {
		 $roles = Permission::find(9)->roles()->lists('name');
		
		if (! App::environment('local'))
		{
		 $hoursManagers = Role::whereIn('name',$roles)->with('users')->get();
		 $email = '';
		 foreach($hoursManagers as $user)
		 {
			
			$email .= $user->users[0]->email . ","; 
			 
		 }
		}else{

			$email = Auth::user()->email; 
			
		}
		 $email = rtrim($email, ",");
		 $emailArray = explode(",",$email);
		 return $emailArray;
		 
		 
	 }
	 
	 private function getPlotUsers($plot_id)
	 {	
	 	$users = User::whereHas('plots', function($q) use($plot_id)
		{
			$q->where('plots.id', '=', $plot_id);
		
		})->lists('id','email');
		 
		 return $users;
	 }
}
