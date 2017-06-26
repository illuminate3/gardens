@extends('site.layouts.default')


    @section('content')
    <h2>Form Details</h2>
    <p><a href="{{route('forms.index')}}">Return to all Forms</a></p>
<p><strong>From:</strong>{{$form->name}}</p>
<p><strong>Email:</strong>
<a title="Email {{$form->name}}" href="mailto:{{$form->email}}">{{$form->email}}</a></p>
<p><strong>Form used:</strong>{{$form->form}}</p>
<p><strong>Comments:</strong>{{$form->comments}}</p>
<p><strong>Phone:</strong>{{$form->phone}}</p>
<p><strong>Date Posted:</strong>{{$form->created_at->format('M j, Y')}}</p>


<a href="{{route('forms.delete',$form->id)}}"><button class="btn btn-danger">Delete Form</button></a>
@endsection