@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($note->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
<meta name="description" content="{{{ $note->meta_description() }}}" />

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
<meta name="keywords" content="{{{ $note->meta_keywords() }}}" />

@stop

@section('meta_author')
<meta name="author" content="{{{ $note->author->username }}}" />
@stop

{{-- Content --}}
@section('content')
<h3>{{ $note->title }}</h3>

<p>{{ $note->content() }}</p>

<div>
	<span class="badge badge-info">Posted {{{ $note->date() }}}</span>
</div>

<hr />

<a id="comments"></a>
<h4>{{ $comments->count() }} {{ \Illuminate\Support\Pluralizer::plural('Comment', $comments->count()) }}</h4>

@if ($comments->count())
@foreach ($comments as $comment)
<div class="row">
	<div class="col-md-1">
		<img class="thumbnail" src="{{asset('assets/images/mosaicsm.png')}}" />
	</div>
	<div class="col-md-11">
		<div class="row">
			<div class="col-md-11">
				<span class="muted">{{{ $comment->author->username }}}</span>
				&bull;
				{{{ $comment->date() }}}
			</div>

			<div class="col-md-11">
				<hr />
			</div>

			<div class="col-md-11">
				{{ nl2br(e($comment->content())) }}
			</div>
		</div>
	</div>
</div>
<hr />
@endforeach
@else
<hr />
@endif

@include('notes.partials.comment_form')

@stop
