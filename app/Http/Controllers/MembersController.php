<?php
namespace App\Http\Controllers;

use App\Http\Requests\MemberFormRequest;
use App\Http\Requests\JoinFormRequest;
use App\Http\Controllers\Controller;
use App\Notifications\HoursAdded;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Member;
use App\User;
use App\Role;
use App\Plot;
use App\Export;



class MembersController extends Controller {
	
	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	protected $user;
	protected $plot;
	protected $member;
	protected $hoursadded;
	
	
	public function __construct(Member $member, User $user,HoursAdded $hoursadded, Plot $plot)
	{
			$this->hoursadded = $hoursadded;
			$this->member = $member;
			$this->user = $user;
			$this->plot = $plot;

	}
	
	
	public function index()
	{
		
		if ($this->user->hasRole('admin'))
		{
			$members = $this->member
			->with('userdetails','userdetails.roles','plots')
			->get();
		}else{
			//only get full members if not admin
			$members = $this->member
			->where('status','=','full')
			->with('userdetails','userdetails.roles','plots')
			->get();
		}
	
		return view('members.index', compact('members','fields'));
	}

	/**
	 * Show the form for creating a new member
	 *
	 * @return Response
	 */
	public function create()
	{
		$plots = $this->plot->plotList();
		$roles= Role::pluck('name','id');
		return view('members.create',compact('plots','roles'));
	}

	/**
	 * Store a newly created member in storage.
	 *
	 * @return Response
	 */
	public function store(MemberFormRequest $request)
	{
		$userData =[
		'email'=> $request->get('email'),
		'password'=>\Hash::make($request->get('password')),
		'username' => strtolower(substr($request->get('firstname'),0,1) .
				str_replace(" ","",$request->get('lastname')))

		];


		$user = new User($userData);;
		$user->save();
		$member = new Member($request->all());
		if($request->has('membersince'))
		{
			$member->membersince = Carbon::parse($request->get('membersince'));
		}
		// have to add the plots and the roles
		$member->user_id = $user->id;
		$user->member()->save($member);
		$user->roles()->sync($request->get('roles'));

		return redirect()->route('members.index');
	}

	/**
	 * Display the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		

		$member = $this->member
			->with('userdetails','plots','userdetails.currentYearHours')
			->whereId($id)
			->firstOrFail();
		
		return view('members.show', compact('member'));
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$member = $this->member
			->where('id','=',$id)
			->with('userdetails','userdetails.roles','plots')
			->firstOrFail();
			
		$plots = $this->plot->plotList();
		$roles= Role::pluck('name','id');
	
		return view('members.edit', compact('member','plots','roles'));
	}

	/**
	 * Update the specified member in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(MemberFormRequest $request, $id)
	{

		$member = $this->member->with('userdetails','userdetails.roles','plots')->findOrFail($id);
		if($request->has('plots')){
			$member->plots()->sync($request->get('plots'));
		}else{
			$member->plots()->detach();
		}


		$member->userdetails->roles()->sync($request->get('roles'));
		
		if($request->has('membersince'))
		{
			$member->membersince = Carbon::parse($request->get('membersince'));
		}

		$member->update();

		return redirect()->route('members.index');
	}

	/**
	 * Remove the specified member from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($member)
	{
		
		$member->delete();

		return redirect()->route('members.index');
	}



	public function waitlist()
	{
		$members = $this->member
		->where('status','=','wait')
		->orderBy('membersince')
		->get();

		$fields = ['Name'=>'firstname','Phone'=>'phone','Date Added'=>'membersince'];
		if ($this->user->hasRole('admin'))
			{
				$fields['Edit'] ='action';
			}
		return view('members.wait', compact('members','fields'));
		
	}
	//should move to NotifyClass
	public function emailMember($id)
	
	{
		$from = $this->member->where('user_id','=',check()->id())->get();
		$to = $this->member->findOrFail($id);

		return view('members.email', compact('to','from'));
		
	}
	
	public function sendEmailMember()
	{
		dd(Input::all());
		
	}
	
	
	public function getBoard()
	{
		$board = $this->user()->hasRole('board');
		
	}
	
	public function join(JoinFormRequest $request)
	{
		
		dd($request);
		$data=$request->all();
	    $data=$this->getUserData($data);

		$user = new User;
		$user->save($data);
		$this->member = new Member;
		
		$member = $this->member->create($data);
		$user = $this->user;
		
		$member->user_id = $user->id;
		$data['yourname'] = $data['firstname'] ." " .$data['lastname'];
		$this->member->sendFormEmails($data);
		return view('pages.response', compact('data'));

		
	}
	
	private function getUserData($data)
	{
		$data['username']= strtolower(substr($data['firstname'],0,1).$data['lastname']);
		$data['password']= rtrim(base64_encode(md5(microtime())),"=");
		$data['password_confirmation'] = $data['password'];
		$data['confirmed']=FALSE;
		
		$data['confirmation_code'] = md5(uniqid(mt_rand(), true));
		$data['membersince'] =date('Y:m:d h:i:s');
		$data['status'] ='wait';
		return $data;
	}

	public function export()
	{
		$members = $this->member->with('userdetails','plots')->get();


		\Excel::create('Members', function($excel)  use($members){

            $excel->sheet('members', function($sheet) use($members) {

                $sheet->loadView('members.export',compact('members'));

            });

        })->export();



		
	}
	
	// Duplicate function could be moved to Model
	private function getUsersPlot($user_id)
	{
	 $plot = $this->plot->whereHas('managedBy', function($q) use($user_id)
		{
			$q->where('user_id', '=', $user_id);
		
		})->first();
		return $plot;
	}
}
