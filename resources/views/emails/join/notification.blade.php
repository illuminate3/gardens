@component('mail::message')

## {{ucwords($data['form'])}} Form Completed

{{ucwords(strtolower($data['name']))}} completed the {{strtolower($data['form'])}} form on the website. 
@if(isset($data['comments']))
This is {{ucwords(strtolower($data['name']))}}'s' message:

>{{$data['comments'] }}
@endif
{{ucwords(strtolower($data['name']))}} can be reached at <a href = "mailto:{{$data['email']}}">{{$data['email']}} or at {{$data['phone']}}</a> 


@endcomponent