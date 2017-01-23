@extends ('site.layouts.default')
@section('content')

<h2>{{($member[0]->firstname)}} {{($member[0]->lastname)}}'s Gardening Diary</h2>
<div class="pull-right">
    <a href="{{{route('diaries.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Diary Entry</a>
</div>
<div><a href="{{route('diaries.list')}}" title='See list view'><i class='glyphicon glyphicon-list-alt'>List</i></a></div>
<?php
$date='';
$events = array();
foreach ($diaries as $event) {
	

		$events[$event->activitydate][$event->id] = $event->title;

}
?>
<style>
td {
	padding:0;
	
}
.day{
		
		width:100px;
		height:100px;
		border:solid 1px black;
		overflow-y: auto;
		padding:0;
		margin:0;
}
</style>

<?php

    $cal = Calendar::make();
    /**** OPTIONAL METHODS ****/
	if(NULL == (Input::get('cdate'))) {
    $cal->setDate(date('Y-m-d')); //Set starting date
	}else{
		$cdate = Input::get('cdate'). '-01';
		$cal->setDate(date('Y-m-d',strtotime($cdate)));
	}
    $cal->setBasePath('/diaries'); // Base path for navigation URLs
    $cal->showNav(true); // Show or hide navigation
    $cal->setView(Input::get('cv')); //'day' or 'week' or null
   
    $cal->setTimeClass('ctime'); //Class Name for times column on day and week views
    $cal->setEventsWrap(array('', '<br/>')); // Set the event's content wrapper
    $cal->setDayWrap(array('<div>','</div>')); //Set the day's number wrapper
    $cal->setNextIcon('<i class="glyphicon glyphicon-forward"></i>'); //Can also be html: <i class='fa fa-chevron-right'></i>
    $cal->setPrevIcon('<i class="glyphicon glyphicon-backward"></i>'); // Same as above
    $cal->setDayLabels(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')); //Label names for week days
    $cal->setMonthLabels(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
	$cal->setAddEventLink("/diaries/create");
	$cal->setEventEditLink("/diaries/edit");
    $cal->setDateWrap(array('<div class="day">','</div>')); //Set cell inner content wrapper
    $cal->setTableClass('table'); //Set the table's class name
    $cal->setHeadClass('table-header'); //Set top header's class name
    $cal->setNextClass('btn'); // Set next btn class name
    $cal->setPrevClass('btn'); // Set Prev btn class name
    $cal->setEvents($events); // Receives the events array
    /**** END OPTIONAL METHODS ****/

    echo $cal->generate() // Return the calendar's html;
	?>
	@stop