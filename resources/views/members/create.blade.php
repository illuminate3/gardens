@extends('site.layouts.default')


    @section('content')
<h1> Create A New Member</h1>


{{Form::open( ['method'=>'POST','route'=>['members.store'],'class'=>'form-horizontal']) }}


@include('members.partials.membersform')
{{Form::submit('Create ',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}
{{-- Scripts --}}
@include('partials._scripts')
@stop
