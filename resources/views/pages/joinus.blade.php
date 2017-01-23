@extends('site.layouts.default')

@section('content')
<h1>Add My Name to the McNear Gardens Wait List</h1>
{{Form::open( ['method'=>'POST','url'=>['join'],'class'=>'form-horizontal']) }}


@include('pages.partials.joinform')

{{Form::submit('Add My Name',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}


    {{-- Scripts --}}
@include('partials._scripts')
@stop