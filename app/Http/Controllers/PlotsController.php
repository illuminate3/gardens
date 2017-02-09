<?php
namespace App\Http\Controllers;

use App\Http\Requests\PlotsFormRequest;
use App\Mail\SummaryHoursEmail;
use App\Plot;
use App\Member;
use App\User;

class PlotsController extends Controller
{
    public $plot;
    public $user;
    public $showYear;
    public function __construct(Plot $plot, User$user)
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
        $members = Member::where('status', '=', 'full')->get();
        return view('plots.create', compact('members'));
    }

    /**
     * Store a newly created plot in storage.
     *
     * @return Response
     */
    public function store(PlotsFormRequest $request)
    {
        $this->plot->create($request->all());

        return redirect()->route('plots.index');
    }

    /**
     * Display the specified plot.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($plot)
    {
        $plot = $this->plot->whereId($plot)->with('managedBy')->firstOrFail();
        
        return view('plots.show', compact('plot', 'diaries'));
    }

    /**
     * Show the form for editing the specified plot.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($plot)
    {
        $assigned=array();
        $plot = $this->plot->where('id', '=', $plot)->with('managedBy')->get();
        foreach ($plot[0]->managedBy as $gardener) {
            $assigned[] = $gardener->id;
        }

        $members = Member::where('status', '=', 'full')->orderBy('lastname')->get();

        return view('plots.edit', compact('plot', 'members', 'assigned'));
    }

    /**
     * Update the specified plot in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(PlotsFormRequest $request, Plot $plot)
    {
        $data = $request->all();
        
        if (isset($data['assigned'])) {
            $plot->managedBy()->sync($data['assigned']);
        } else {
            $plot->managedBy()->detach();
        }
        $plot->update($data);

        return redirect()->route('plotlist');
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

        return redirect()->route('plots.index');
    }


    public function plotlist()
    {
        $plots = $this->plot->findOrFail(1)->with('managedBy')->get();

        $fields=['Number'=>'plotnumber','Sub'=>'subplot',
            'Type'=>'type',
            'Area'=>'area','Comments'=>'description','Assigned To'=>'managedBy'];
        if (\Auth::user()->can('manage_plots')) {
            $fields['Edit']='action';
        }
        return view('plots.index', compact('plots', 'fields'));
    }
    public function getPlotHours()
    {
        $plots = $this->getPlotSummaryHours();
        $plotsummary = $this->getPlotSummaryDetails($plots);
        $fields = ['description','type','name','sum','address','meeting commitment'];
        return view('plots.summary', compact('plotsummary', 'fields'));
    }
    private function getPlotSummaryHours($id = null)
    {
        $showYear = date('Y');
        $query = "SELECT 
			plots.id, plots.description as description, plots.type as type, members.firstname as firstname, users.email as email,sum(hours) as total
				FROM `plots`,`member_plot`,`members`,`users`
                left join hours on users.id = hours.user_id 
                    and YEAR(servicedate) = ". $showYear. "
				WHERE plots.id = member_plot.plot_id 
				and member_plot.member_id = members.id
				and members.user_id = users.id
				and members.status = \"full\"
				group by users.id,plots.id
                order by plots.id";
        $plots =  \DB::select(\DB::raw($query));
        
        /*$plots = $this->plot->with('managedBy','managedBy.userdetails','managedBy.userdetails.sumCurrentHours')

        
        
        ->get();*/
        
        return $plots;
    }



    public function checkSummaryEmails()
    {
        $plots = $this->getPlotSummaryHours();
        $plotsummary = $this->getPlotSummaryDetails($plots);

        $random_key = array_rand($plotsummary);
        $plotemail =  $plotsummary[$random_key];
        return view('emails.confirmsummary', compact('plotemail'));
    }

    public function sendSummaryEmails()
    {
        $plots = $this->getPlotSummaryHours();
        $plotsummary = $this->getPlotSummaryDetails($plots);
        $messageCount = 0;
        foreach ($plotsummary as $plotemail) {
            \Mail::to($plotemail['address'])->send(new SummaryHoursEmail($plotemail));

            $messageCount++;
        }
        $message = "Sent " . $messageCount . " messages";
        return redirect()->route('hourssummary')->with('success', $message);
    }
        
    private function getPlotSummaryDetails($plots)
    {
        $plotsummary = array();
        
        foreach ($plots as $plot) {
            if (! isset($plotsummary[$plot->id])) {
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
        
        foreach ($plots as $plot) {
            if (isset($plot->managedBy) && count($plot->managedBy) >0) {
                $lastname = '';
                $plotter = '';
                foreach ($plot->managedBy as $member) {
                    if ($member->lastname != $lastname) {
                        $plotter.= $member->lastname."/";
                        $lastname = $member->lastname;
                    }
                }
                $plotter = substr($plotter, 0, -1);
                $plot->description = $plotter;
                $plot->save();
            }
        }
    }
}
