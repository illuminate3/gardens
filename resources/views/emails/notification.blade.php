@component('mail::message')

## {{$data['form']}} Form Completed

{{ucwords(strtolower($data['name']))}} completed the {{strtolower($data['form'])}} form on the website. This is {{ucwords(strtolower($data['name']))}}'s' message:

>{{$data['comments']}}

{{ucwords(strtolower($data['name']))}} can be reached at <a href = "mailto:{{$data['email']}}">{{$data['email']}}</a> 


@endcomponent