@extends ('site.layouts.default')
@section('content')
<h1>Edit Plot {{$plot[0]->plotnumber . ' / ' . $plot[0]->subplot }}</h1>

{{Form::model($plot, ['method'=>'PATCH','route'=>['admin.plots.update', $plot[0]->id],'class'=>'form-horizontal']) }}


@include('plots.partials.plotsform')
{{Form::submit('Update',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}


{{-- Scripts --}}
@include('partials._scripts')
@stop