@extends('site.layouts.default')
{{-- Content --}}
@section('content')

<div class="page-header">
	<h1>Your Profile</h1>
</div>

     @while(list($key,$field)=each($fields))
    @if(is_array($field))
    
		<p>{{$key}}:Thats an array</p>
	@else
    <p>{{$key}}: {{$user[0]->$field}} </p>
    @endif
     @endwhile



{{-- Scripts --}}
@include('partials._scripts')
@stop
