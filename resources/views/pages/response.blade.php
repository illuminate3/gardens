@extends('site.layouts.default')

@section('content')

<h1>Thank You!</h1>
<p>Thank you, {{$data['name']}} for completing the {{$data['form']}} on the McNearCommunity  Gardens website.</p>

<p>If neccessary someone will contact you shortly about your message. </p>

<p>Webmaster : McNear Gardens</p>
    {{-- Scripts --}}
@include('partials._scripts')
@stop
