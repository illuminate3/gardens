@extends('site.layouts.default')
@section('content')
<h1>Add a Garden Note</h1>
{{Form::open(array('route'=>'notes.store'))}}

@include("notes.partials._notesform")
{{Form::submit('Add Note',array('class'=>"btn btn-primary" ))}}

{{Form::close()}}


@include('partials._scripts')
@stop