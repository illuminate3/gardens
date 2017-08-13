<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\PeriodTrait;

class Hours extends Model
{
    use PeriodTrait;

    public $showYear;
    public $dates =['created_at','updated_at','servicedate','starttime','endtime'];
    public $fillable = ['starttime','endtime','servicedate','description','hours','user_id','trans_id'];
    
    // Add your validation rules here
    

    // Don't forget to fill this array


    public function gardener()
    {
        return $this->belongsTo(Member::class, 'user_id', 'user_id');
    }
    
    
    private function cleanseString($string)
    {
        $string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
        $string = str_replace(",", " ", $string);
        return $string;
    }

    public function getAllDetailHours($plot = null)
    {
        $this->showYear = $this->getShowYear();
        if ($plot) {
            // convert plot to users
            
            $users = Plot::with('managedBy', 'managedBy.user')->where('id', '=', $plot)->firstOrFail();
            
            foreach ($users->managedBy as $member) {
                //dd($member->user->id);
                $user_id[]=  $member->user->id;
            }

            // get users hours
            $hours = Hours::whereIn('user_id', $user_id)
                ->where(\DB::raw('YEAR(starttime)'), '=', $this->showYear)
                ->with('gardener')
                ->orderBy('starttime')
                ->get();
                
        } else {

            //Cant we simplify this. Probably need join?
            //$hours = $this->hour->where(DB::raw('YEAR(starttime)'), '=', $this->showyear)->with('gardener')->orderBy('starttime')->get();
            //$fields = ['servicedate','hours','description','gardener','plot'];
            $query = "select 
				starttime,
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
				and YEAR(starttime) = '". $this->showYear."'
			ORDER BY plotnumber";
            
            $hours = \DB::select(\DB::raw($query));
        }
        
        return $hours;
    }

    public function getAllHours()
    {
        $this->showYear = $this->getShowYear();
        // I am sure we can simplify this
        $query ="SELECT 
					users.id as id, 
					firstname,lastname, 
					YEAR(starttime) as year,
					MONTH(starttime) as month, 
					SUM(hours) as hours 
				
				FROM 
					users,
					members,
					hours 
					
				WHERE 
					hours.user_id = users.id
					and members.user_id = users.id 
					and YEAR(starttime) = '".$this->showyear."' 
				
				GROUP BY 
					id,
					lastname,
					firstname,
					YEAR(starttime), 
					MONTH(starttime) 
				
				ORDER BY 
					lastname,
					firstname,
					month,
					year";

        $hours = \DB::select(\DB::raw($query));
        
        return $hours;
    }
    public function calculateHours($inputdata)
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
        }
        return $data;
    }

    public function exportHours($hours)
    {
        \Excel::create('Hours', function ($excel) use ($hours) {
            $excel->sheet('hours', function ($sheet) use ($hours) {
                $sheet->loadView('hours.export', compact('hours'));
            });
        })->export();
    }
}
