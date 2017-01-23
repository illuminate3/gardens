@extends ('site.layouts.default')
@section('content')
<h1>Add Diary Entry</h1>

{{Form::model('', ['method'=>'POST','route'=>['diaries.store']]) }}


@include('diaries.partials._diaryform')
{{Form::submit('Add',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}


{{-- Scripts --}}
@include('partials._scripts')



<script type="text/javascript" src="{{asset('/assets/js/bootstrap-datepicker.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker3.css')}}"/>
<script>


 
$('#datepicker .input-group.date').datepicker({
});



</script>
@stop