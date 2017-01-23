@extends ('site.layouts.default')


@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger alert-block">
	<p>You must enter hours and a description of work performed</p>
</div>

@endif

<h1>Enter your hours</h1>

<div>
{{Form::open(array('route'=>'hours.multistore'))}}

@include('hours.partials.multihoursform')
<div class="col-sm-6">
<div class="form-group">
{{Form::submit('submit',array('class'=>'btn btn-primary'))}}
</div></div>

{{Form::close()}}
</div>
@include('partials._scripts')
@include('partials._datetime')
@stop