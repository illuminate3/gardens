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
{{Form::open(array('route'=>'hours.matrix', 'method' => 'post','class'=>'form', 'id'=>'updateHours'))}}
{{csrf_field()}}

<table >
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
				
			
			for($month;$month <= 12;$month++)
			{
				echo  "<td style ='text-align:right' >
				<input type=\"text\" 
				size=\"5\" 
				name=\"plothour[".$plot."][".$month."]\" 
				value=\"0\">
				</td>" ;
			}
				
				
				
				
			}
			// write out the total data in columns 14
			
				$commitment < $total ? $class = 'success' : $class = '';
				if($plot){
				echo "<td style ='text-align:right'  class = '".$class."' > 
				<input type=\"text\" size=\"5\" 
				name=\"plothour[".$plot."][".$month."]\" 
				disabled 
				
				value=\"". number_format ( $total,2)."\"></td>";
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
			//$num = $hour->month - $month;
			
			for($i=$month;$i < $hour->month;$i++)
			{
				echo  "<td style ='text-align:right' >
			<input type=\"text\" size=\"5\" 
			name=\"plothour[".$plot."][".$i."]\" 
			value =\"0\">
			</td>" ;
			}
		}
		if(($commitment / 12) * $month <= $total)
		{
			$class = 'success';
		}else{
			$class = '';	
			
		}
		echo "<td style ='text-align:right' class = '".$class."' >
			<input type=\"text\" size=\"5\" 
				name=\"plothour[".$plot."][".$hour->month."]\" 
				
				value=\"". number_format (  $hour->hours,2)."\">
				</td>";
		
		$month = $hour->month + 1;
		
	}
	
}	

// handle the last item in the list
		if($month != 14 && $month > 0) 
			{
				
			
				for($i=$month;$i < 13;$i++)
				{
					echo  "<td style ='text-align:right' >
				<input size=\"5\" type=\"text\" 
				name=\"plothour[".$hour->plotid."][".$i."]\"
				value=\"0\">
				</td>" ;
				}
				
				
			
			}
			// write out the months data in columns 3 - 14
			
				$commitment < $total ? $class = 'success' : $class = '';
				if($plot){
				echo "<td style ='text-align:right'  class = '".$class."' >
				<input type=\"text\" size=\"5\" 
				name=\"plothour[".$hour->plotid."][".$month."]\"
				disabled 
				value=\"". number_format ( $total,2)."\">
				</td>";
				}
?>
</tbody>
</table>
{{csrf_field()}}
{{Form::submit()}}
{{Form::close()}}
</div>
{{-- Scripts --}}
@include('partials._scripts')
@stop
