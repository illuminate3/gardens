@extends ('site.layouts.default')


@section('content')
<h1>Enter your hours</h1>


{{Form::open(array('route'=>'hours.store'))}}

@include('hours.partials.hoursform')
<div class="col-sm-6">
<div class="form-group">
{{Form::submit('submit',array('class'=>'btn btn-primary'))}}
</div></div>

{{Form::close()}}
@include('partials._scripts')
@include('partials._datetime')
@stop