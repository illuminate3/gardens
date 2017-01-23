@extends ('site.layouts.default')
@section('content')
@include('partials/_modal')
<?php $date = '';?>
<h2>Recent Garden Diary Entries</h2>
@foreach ($diaries as $diary)

@if($diary['activitydate'] != $date)
	<?php $date = $diary['activitydate'];?>
	
	<p><strong>{{ Carbon::parse($diary['activitydate'])->toFormattedDateString()}}</strong></p>
@endif

<p style="margin-left:20px"><strong>{{$diary['title']}}</strong> {{$diary['notes']}}<em> {{$diary['author']['member']['firstname']}} {{$diary['author']['member']['lastname']}}</em></p>
@endforeach
@include('partials._scripts')
@stop