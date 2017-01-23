@extends('site.layouts.default')


    @section('content')
<h1> Edit {{$member->firstname . ' ' . $member->lastname}} Member Details</h1>


{{Form::model($member, ['method'=>'PATCH','route'=>['admin.members.update', $member->id],'class'=>'form-horizontal']) }}


@include('members.partials.membersform')
{{Form::submit('Update',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}
{{-- Scripts --}}
@include('partials._scripts')
@include('partials._datetime');
@stop
