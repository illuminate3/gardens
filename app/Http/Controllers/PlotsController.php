<?php
namespace App\Http\Controllers;
use App\Plot;
use App\Member;
use App\User;

class PlotsController extends Controller {


	public $plot;
	public $user;
	public $showYear;
	public function __construct(Plot $plot,User$user)
	{
		$this->plot = $plot;
		$this->user = $user;

	}
	
	/**
	 * Display a listing of plots
	 *
	 * @return Response
	 */
	public function index()
	{
		$plots = $this->plot->findOrFail(1)->with('managedBy')->get();
		return view('plots.plotmap2', compact('plots'));
	}

	/**
	 * Show the form for creating a new plot
	 *
	 * @return Response
	 */
	public function create()
	{
		$members = Member::where('status','=','full')->get();
		return view('plots.create',compact('members'));
	}

	/**
	 * Store a newly created plot in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), $this->plot->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$this->plot->create($data);

		return Redirect::route('plots.index');
	}

	/**
	 * Display the specified plot.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$plot = $this->plot->whereId($id)->with('managedBy')->firstOrFail();
		
		return view('plots.show', compact('plot','diaries'));
	}

	/**
	 * Show the form for editing the specified plot.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($plots)
	{
		$assigned=array();
		$plot = $this->plot->where('id','=',$plots->id)->with('managedBy')->get();
		foreach($plot[0]->managedBy as $gardener)
		{
			$assigned[] = $gardener->id;	
		}

		$members = Member::where('status','=','full')->orderBy('lastname')->get();

		return view('plots.edit', compact('plot','members','assigned'));
	}

	/**
	 * Update the specified plot in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($plot)
	{
		
		
		$this->plot=$plot;

		$validator = Validator::make($data = Input::all(), $this->plot->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		if(isset($data['assigned'])){
			$plot->managedBy()->sync($data['assigned']);
		}else{
			$plot->managedBy()->detach();
		}
		$plot->update($data);
		
		

		return Redirect::route('plotlist');
	}

	/**
	 * Remove the specified plot from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->plot->destroy($id);

		return Redirect::route('plots.index');
	}


	public function plotlist()
	{
		
		$plots = $this->plot->findOrFail(1)->with('managedBy')->get();

		$fields=['Number'=>'plotnumber','Sub'=>'subplot',
			'Type'=>'type',
			'Area'=>'area','Comments'=>'description','Assigned To'=>'managedBy'];
		if ($this->user->hasRole('admin'))
		{

		$fields['Edit']='action';
		}
		return view('plots.index', compact('plots','fields'));
		
		
		
	}
	public function getPlotHours()
	{
		$plots = $this->getPlotSummaryHours();
		$plotsummary = $this->getPlotSummaryDetails($plots);
		$fields = ['description','type','name','sum','address','met commitment'];
		return view('plots.summary', compact('plotsummary','fields'));

	}
	private function getPlotSummaryHours($id = null)
	{
		$showYear = '2016';
		
		$plots = DB::select("SELECT 
			plots.id, plots.description as description, plots.type as type, members.firstname as firstname, users.email as email,sum(hours) as total
				FROM `plots`,`member_plot`,`members`,`users`
                left join hours on users.id = hours.user_id 
                    and YEAR(servicedate) = 2016
				WHERE plots.id = member_plot.plot_id 
				and member_plot.member_id = members.id
				and members.user_id = users.id
				and members.status = \"full\"
				group by users.id,plots.id
                order by plots.id");
		/*$plots = $this->plot->with('managedBy','managedBy.userdetails')
		->whereHas('managedBy.userdetails.serviceHours', function($query) use ($showYear) {
        	$query->where(DB::raw('YEAR(servicedate)'),'=', $showYear);
    	})
    	->get();*/
    	return $plots;
    }



    public function sendSummaryEmails()
    {
    		
		$plots = $this->getPlotSummaryHours();
		$plotsummary = $this->getPlotSummaryDetails($plots);
		$messageCount = 0;
		foreach ($plotsummary as $plotemail)
		{
			Mail::send('emails.summary',$plotemail, function($message) use ($plotemail)
				{
				$message->to($plotemail['address'])->subject('Your 2016 service hours');
				
				});
			$messageCount++;
		}
		$message = "Sent " . $messageCount . " messages";
		return Redirect::route('hourssummary')->with('success', $message);
        

    }
    	
    private function getPlotSummaryDetails($plots)
    {


    	$plotsummary = array();
    	
		foreach ($plots as $plot)
		{
			if(! isset($plotsummary[$plot->id]))
				{
					$plotsummary[$plot->id]['sum'] =0; 
				}
			$plotsummary[$plot->id]['name'][] = $plot->firstname;
			$plotsummary[$plot->id]['sum'] = $plotsummary[$plot->id]['sum'] + $plot->total;
			$plotsummary[$plot->id]['type'] = $plot->type;
			$plotsummary[$plot->id]['description'] = $plot->description;
			$plotsummary[$plot->id]['address'][] = $plot->email;
			
		}
		return $plotsummary;
	}


	
	public function nameplots()
	{
		$plots = $this->plot->findOrFail(1)->with('managedBy')->get();
		
		foreach($plots as $plot)
		{

			
			if(isset($plot->managedBy) && count($plot->managedBy) >0 )
			{
				
				$lastname = '';
				$plotter = '';
				foreach($plot->managedBy as $member)
				{
					if($member->lastname != $lastname)
					{
						$plotter.= $member->lastname."/";
						$lastname = $member->lastname;
					}
				}
			$plotter = substr($plotter,0,-1);
			$plot->description = $plotter;
			$plot->save();	
			}
		}
	}
}
