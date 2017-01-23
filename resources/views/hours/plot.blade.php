@extends ('site.layouts.default')
@section('content')
<h1>All Hours By Plot</h1>
<p>(see <a href="{{route('hours.all')}}">hours by member</a>)</p>

<a href = "{{route('hours.index')}}">Review & Update Your Hours</a>
<div class="pull-right">
    <a href="{{{route('hours.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
</div>
<div>@if(Auth::user()->can('manage_hours'))</div>

<a href= "{{{route('hours.download') }}}" title="Export Hours" ><i class="glyphicon glyphicon-cloud-download"></i> Export Hours</i></a>
@endif
{{Form::open(array('route'=>'hours.all', 'method' => 'get','class'=>'form', 'id'=>'selectForm'))}}
@include('hours.partials._year')

{{Form::close()}}
<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
<?php $months= ['Plot','Plot Type','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Tot'];

$totalHours = "";
echo "<thead>";
foreach ($months as $monthtitle) 
{
	echo "<th>". $monthtitle."</th>";
	
}
echo "</thead>";
echo "<tbody>";
$plot=NULL;
$month=0;
$total=0;


foreach($hours as $hour)
{
	
	if(! $plot)
	{
		$commitment = ($hour->type == 'partial' ? '12' : '24');
	}
	// check if we are starting a new row
	if($hour->plotid != $plot) 
	{
			//write out the missing months to the full year
			if($month != 14 && $month > 0) 
			{
				echo str_repeat ( "<td style ='text-align:right' >0 </td>" ,  13 - $month ) ;
			}
			// write out the total data in columns 14
			
				$commitment < $total ? $class = 'success' : $class = '';
				if($plot){
				echo "<td style ='text-align:right'  class = '".$class."' >".  number_format ( $total,2)."</td>";
				}
		$total = 0;
		$plot = $hour->plotid;
		$commitment = ($hour->type == 'partial' ? '12' : '24');
		$month=1;
		// write out the name and type of plot
		echo "<tr><td><a href=\"". url('plots/'.$hour->plotid). "\">".$hour->plot."</a></td>";
		echo "<td>".$hour->type."</td>";
	}
	

	if($hour->month ) {
		
		$total = $total + number_format ( $hour->hours,2);
		if($month  < $hour->month)
		{
			echo str_repeat ( "<td style ='text-align:right' >0</td>" ,  $hour->month - $month ) ;
		}
		if(($commitment / 12) * $month <= $total)
		{
			$class = 'success';
		}else{
			$class = '';	
			
		}
		echo "<td style ='text-align:right' class = '".$class."' >". number_format ( $hour->hours,2 ) ."</td>";
		
		$month = $hour->month + 1;
		
	}
	
}	

// handle the last item in the list
if($month != 14 && $month > 0) 
			{
				echo str_repeat ( "<td style ='text-align:right' >0 </td>" ,  13 - $month ) ;
			}
			// write out the months data in columns 3 - 14
			
				$commitment < $total ? $class = 'success' : $class = '';
				if($plot){
				echo "<td style ='text-align:right'  class = '".$class."' >".  number_format ( $total,2)."</td>";
				}
?>
</tbody>
</table>
</table></div>
{{-- Scripts --}}
@include('partials._scripts')
@stop
