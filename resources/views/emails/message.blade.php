@component('mail::message')
New message from {{$user->member->firstname}} {{$user->member->lastname}}:
@component('mail::panel')
{{$post->content}}
@endcomponent
@endcomponent