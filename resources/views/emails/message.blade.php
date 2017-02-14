@component('mail::message')

@if(isset($comment))
#### New comment from {{$user->member->firstname}} {{$user->member->lastname}}:
@component('mail::panel')
{{$comment->content}}
@endcomponent
#### Original Message
@else
#### New message from {{$user->member->firstname}} {{$user->member->lastname}}:

@endif
@component('mail::panel') 
{{$post->author->member->firstname}} {{$post->author->member->lastname}} posted<br />
{{$post->content}}

Posted: {{date('Y-m-d',strtotime($post->created_at))}}</em>
@endcomponent

@foreach ($post->comments as $comment)
@component('mail::panel')
{{$comment->author->member->firstname}} {{$post->author->member->lastname}} commented:<br/>
{{$comment->content}}

Commented: {{date('Y-m-d',strtotime($comment->created_at))}}</em>
@endcomponent
@endforeach

@endcomponent