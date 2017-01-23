@extends('site.layouts.default')

@section('content')
<h1>Contact McNear Gardens</h1>
{{Form::open( ['method'=>'POST','url'=>['contact'],'class'=>'form-horizontal']) }}


@include('pages.partials.contactform')

{{Form::submit('Send ',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}


    {{-- Scripts --}}
@include('partials._scripts')
@stop