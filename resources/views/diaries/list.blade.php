@extends ('site.layouts.default')
@section('content')
@include('partials/_modal')
<?php $date = '';?>
<h2>{{($member[0]->firstname)}} {{($member[0]->lastname)}}'s Gardening Diary</h2>
<div class="pull-right">
    <a href="{{{route('diaries.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Diary Entry</a>
</div>
<div><a href="{{route('diaries.index')}}" title='See calendar view'><i class='glyphicon glyphicon-calendar'>Calendar</i></a></div>

@foreach ($diaries as $diary)

@if($diary['activitydate'] != $date)
	<?php $date = $diary['activitydate'];?>
	
	<p><strong>{{ Carbon::parse($diary['activitydate'])->toFormattedDateString()}}</strong></p>
@endif
<p><a href="{{route('diaries.edit',$diary['id'])}}" title= 'Edit this entry' ><i class="glyphicon glyphicon-pencil"></i></a>

<a data-href="diaries/{{$diary['id']}}/delete" title="Delete this entry" data-toggle="modal" data-target="#confirm-delete" data-title = " {{$diary['title']}}" href="#"><i class="glyphicon glyphicon-remove"></i></a>

<strong>{{$diary['title']}}</strong> {{$diary['notes']}}</p>
@endforeach
@include('partials._scripts')
@stop