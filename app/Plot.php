<?php
namespace App;

use App\PeriodTrait;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    use PeriodTrait;

    // Add your validation rules here
    

    // Don't forget to fill this array
    protected $fillable = ['plotnumber','subplot','type','width','length','row','col','description'];

    
    public function managedBy()
    {
        return $this->belongsToMany(Member::class)->with('user');
    }
    
    public function getPlotHours($plot = null, $id=null, Request $request)
    {
        $this->getShowYear($request);
        
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
                
        if ($plot) {
            $query.=" and plotnumber = ". $plot;
        }
        if ($id) {
            $query.=" and plots.id = ". $id;
        }
                
        
        $query.="
				GROUP BY
					plots.id, year, month
				 ORDER BY 
					plots.description,-month DESC, -year DESC";

        $hours = \DB::select(\DB::raw($query));

        return $hours;
    }

    public function scopePlotList(){
    	return $this->select(\DB::raw("CONCAT(description, ' ' ,plotnumber,'/ ',subplot) AS plot"),'id')->orderBy('plot')->pluck('plot', 'id');

    }
}
