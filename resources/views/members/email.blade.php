@extends('site.layouts.default')

    @section('content')
    <h1>Your Email to {{$to->firstname}}</h1>
   {{Form::open( ['method'=>'POST','route'=>['members.email'],'class'=>'form-horizontal']) }}
  	 <div class="form-group">
	{{Form::label('message','Your Message:',array('class'=>'col-sm-2 control-label'))}}
    <div class="col-sm-10">
    {{Form::textarea('message')}}
    <span class='error'>{{$errors->first('message')}}</span>
    </div></div>
{{Form::hidden('from',$from[0]->id)}}
{{Form::hidden('to',$to->user_id)}}
{{Form::submit('Send EMail ',array('class'=>"btn btn-primary" ))}}
{{Form::close()}}
    
    
    @stop