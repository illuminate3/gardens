@extends ('site.layouts.default')
@section('content')
<h1>Add Plot</h1>

{{Form::model('', ['method'=>'POST','route'=>['admin.plots.store']]) }}


@include('plots.partials.plotsform')
{{Form::submit('Add',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}


{{-- Scripts --}}
@include('partials._scripts')
@stop