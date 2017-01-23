@extends ('site.layouts.default')
@section('content')

<h1>Garden Note Book</h1>
<div class="pull-right">
    <a href="{{{ URL::to('notes/create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add New Note</a>
</div>
@foreach ($notes as $post)
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{route('shownote', trim($post->slug))}}">{{ String::title($post->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ $post->url() }}}" class="thumbnail"><img src="{{asset('assets/images/mosaic1.png')}}" 
                title="Read more about {{String::title($post->title)}}" alt="" border='0'></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
				<p><a class="btn btn-mini btn-default" href="{{{ $post->url() }}}">Read more</a></p>
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $post->url() }}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach

{{ $notes->links() }}

@stop




{{-- Scripts --}}
@include('partials._scripts')
@stop
