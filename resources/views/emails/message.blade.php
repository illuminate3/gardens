@component('mail::message')

@if(isset($comment))
#### New comment from {{$user->member->firstname}} {{$user->member->lastname}}:
@component('mail::panel')
{{$comment->content}}
@endcomponent
#### Original Message
{{$post->author->member->firstname}} {{$post->author->member->lastname}} posted on 
{{{{date('Y-m-d',strtotime($post->created_at)}}
<br />
@else
#### New message from {{$user->member->firstname}} {{$user->member->lastname}}:

@endif
@component('mail::panel') 

{{$post->content}}

Posted: {{date('Y-m-d',strtotime($post->created_at))}}</em>
@endcomponent
<hr />

@foreach ($post->comments as $othercomment)
@if($othercomment->id!= $comment->id)
@component('mail::panel')
{{$othercomment->author->member->firstname}} {{$othercomment->author->member->lastname}} commented:<br/>
{{$othercomment->content}}

Commented: {{date('Y-m-d',strtotime($othercomment->created_at))}}</em>
@endcomponent
@endif
@endforeach

@endcomponent