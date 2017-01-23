@extends('site.layouts.default')

@section('content')

<h1>{{$page[0]->title}}</h1>
<p>{{$page[0]->text}}</p>
    {{-- Scripts --}}
@include('partials._scripts')
@stop
