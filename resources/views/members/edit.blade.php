@extends('site.layouts.default')


    @section('content')
<h2> Edit Member Details</h2>


{{Form::model($member, ['method'=>'PATCH','route'=>['members.update', $member->id],'class'=>'form-horizontal']) }}


@include('members.partials.membersform')
{{Form::submit('Update',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}
{{-- Scripts --}}
@include('partials._scripts')
@include('partials._datetime');
@stop
