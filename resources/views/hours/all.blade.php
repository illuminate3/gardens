@extends ('site.layouts.default')
@section('content')
<h1>All Hours by Member</h1>
<p>(see <a href="{{route('hours.plot')}}">hours by plot</a>)</p>
<a href = "{{route('hours.index')}}">Review & Update Your Hours</a>
<div class="pull-right">
    <a href="{{{route('hours.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
        
        <a href="{{{route('hours.multiple') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Multiple Hours</a>
</div>

<div>@if(Auth::user()->can('manage_hours'))</div>

<a href= "{{{route('hours.download') }}}" title="Export Hours" ><i class="glyphicon glyphicon-cloud-download"></i> Export Hours</i></a>
@endif
{{Form::open(array('route'=>'hours.all', 'method' => 'get','class'=>'form', 'id'=>'selectForm'))}}
@include('hours.partials._year')

{{Form::close()}}
<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>

<?php $months= ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Tot'];

$totalHours = "";
echo "<thead>";
foreach ($months as $monthtitle) 
{
	echo "<th>". $monthtitle."</th>";
	
}
echo "</thead>";
echo "<tbody>";
$person=NULL;
$month=0;
$total=0;


foreach($hours as $hour)
{
	if($hour->id != $person ) {
		if($month < 13 && $month > 0) {
			
			echo str_repeat ( "<td style ='text-align:right' >0</td>" ,  13 - $month ) ;
		}
		if($month !=0){
			echo "<td style ='text-align:right' >".  $total."</td>";
		}

		$total = 0;
		$person = $hour->id;
		$month="1";
	
		echo "<tr><td><a href=\"". route('hours.show',array($hour->id,'y'=>$showyear)). "\">".$hour->lastname . ", " . $hour->firstname."</a></td>";
		
	}
	if($month < $hour->month){
		echo str_repeat ( "<td style ='text-align:right' >0</td>" ,  $hour->month - $month ) ;
	}
	echo "<td style ='text-align:right' >";
	echo "<a href =\"". route('hours.show',array($hour->id,'y'=>$showyear,'m'=>$hour->month)). "\">";
	echo  number_format ( $hour->hours,2 ) ."</a></td>";
	
	$total = $total + number_format ( $hour->hours,2);

	$month = $hour->month + 1;
}

if($month != 13  && $month != 0) {
			echo str_repeat ( "<td  style ='text-align:right'>0</td>" ,  13 - $month ) ;
			
		}
		if($month !=0){
		echo "<td style ='text-align:right' >".  number_format ( $total,2)."</td>";
		}
?>

</tbody>
<tfoot>

</tfoot>
</table>
</div>
{{-- Scripts --}}
@include('partials._scripts')
@stop
