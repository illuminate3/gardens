@extends ('site.layouts.default')
@section('content')
<h1>Edit Diary Entry</h1>

{{Form::model($diary, ['method'=>'PATCH','route'=>['diaries.update', $diary->id],'class'=>'form-horizontal']) }}


@include('diaries.partials._diaryform')
{{Form::submit('Edit',array('class'=>"btn btn-primary" ))}}
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