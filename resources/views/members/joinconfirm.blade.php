@extends('site.layouts.default')

@section('content')


 <h2> {{$user->member->fullname()}}</h2>  
<p>{{$user->member->firstname}}</p>
    <p>Thank you for confirming your application for the McNear Community Gardens.  You are currently on the wait list.  We will keep you posted as the list changes.  Should your plans change please email us at info@mcneargardens.com.
    <fieldset><legend>Contact Details</legend><blockquote>
    <p><strong>First Name:</strong>{{$user->member->firstname}}</p>
    <p><strong>Last Name:</strong>{{$user->member->lastname}}</p>
    <p><strong>Phone:</strong>{{$user->member->phone}}</p>  
    <p><strong>Address:</strong>{{$user->member->address}}</p>
    <p><strong>Email:</strong>{{$user->member->user->email}}</p>
    </blockquote>
    </fieldset>
    

    Thanks for your interest in McNear Community gardens and we look forward to seeing you in the gardens soon.

    

@stop
