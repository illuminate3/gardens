<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\HoursAdded;
use App\Member;
use App\User;
use App\Plot;
use App\Export;



class MembersController extends Controller {
	
	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	public $user;
	public $member;
	
	
	public function __construct(Member $member, User $user)
	{
			$this->member= $member;
			$this->user= $user;

	}
	
	
	public function index()
	{
		
		if ($this->user->hasRole('admin'))
		{
			$members = $this->member
			->with('userdetails','plots')
			->get();
		}else{

			$members = $this->member
			->where('status','=','full')
			->with('userdetails','plots')
			->get();
		}
	
		$this->user->notify(new HoursAdded($this->user));
	$fields = ['First Name'=>'firstname','Last Name'=>'lastname','Phone'=>'phone','Plots'=>'plots','Type'=>'type'];
	if ( \Auth::user()->can('manage_members'))
		{
			$fields['Edit'] ='action';
			$fields['Status']='status';
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
		$plots = Plot::all();
		return view('members.create',compact('plots'));
	}

	/**
	 * Store a newly created member in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = $this->member->rules;
		
		$validator = Validator::make($data = Input::all(),$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$this->member->create($data);

		return Redirect::route('members.index');
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
		->with('userdetails','plots')
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
		

		$assigned = array();
		$member = $this->member->where('id','=',$id)->with('userdetails','plots')->firstOrFail();

		$plots = Plot::all();
		
		foreach($member->plots as $plot)
		{
			$assigned[] = $plot->id;	
		}

		return view('members.edit', compact('member','plots','assigned'));
	}

	/**
	 * Update the specified member in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($member)
	{
		
		$rules = $this->member->rules;
		$rules['email'] = 'required';
		$validator = Validator::make($data = Input::all(),$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		if(isset($data['plots'])){
			$member->plots()->sync($data['plots']);
		}else{
			$member->plots()->detach();
		}
		if(isset ($data['membersince']))
		{
			$data['membersince'] = date('Y:m:d 00:00:00',strtotime($data['membersince']));
		}

		$member->update($data);

		return Redirect::route('members.index');
	}

	/**
	 * Remove the specified member from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Member $member)
	{
		
		$member->destroy();

		return Redirect::route('members.index');
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
	
	public function emailMember($id)
	
	{
		$from = $this->member->where('user_id','=',Auth::id())->get();
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
	
	public function join()
	{
		$validator = Validator::make($data = Input::all(),$this->member->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


    $data['username']=strtolower(substr($data['firstname'],0,1).$data['lastname']);
   	$data['password']= rtrim(base64_encode(md5(microtime())),"=");
	$data['password_confirmation'] = $data['password'];
	$data['confirmed']=FALSE;
	
	$data['confirmation_code'] = md5(uniqid(mt_rand(), true));
	$user = new User;
	$user->save($data);

	$data['membersince'] =date('Y:m:d h:i:s');
	$data['status'] ='wait';
	$member = $this->member->create($data);
	$user = $this->user;
	
	
	$user->password = rtrim(base64_encode(md5(microtime())),"=");
	$user->save();
	dd($user->id);
	$member->user_id = $user->id;
	$data['yourname'] = $data['firstname'] ." " .$data['lastname'];
	$this->member->sendFormEmails($data);
	return view('pages.response', compact('data'));

		
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
	 $plot = Plot::whereHas('managedBy', function($q) use($user_id)
		{
			$q->where('user_id', '=', $user_id);
		
		})->first();
		return $plot;
	}
}
