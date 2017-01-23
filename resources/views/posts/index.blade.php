@extends ('site.layouts.default')
@section('content')


    <h1>All Posts</h1>
    <div class="pull-right">
        <a href="{{{ route('posts.create') }}}" class="btn btn-small btn-info iframe">
            <span class="glyphicon glyphicon-plus-sign"></span> New Posting</a>
    </div>
    
    @foreach($posts as $post)
       
            <h2><a href= "{{route('posts.show',$post->id)}}">{{$post->title}}</a></h2>
            <p>{{$post->content}}</p>
            <p>{{$post->author->member->firstname}} {{$post->author->member->lastname}}</p>
            <p>{{$post->created_at}}</p>
            <p>{{$post->comments->count()}} Replies</p>

            <hr />
    @endforeach
    

{{-- Scripts --}}
@include('partials._scripts')
@stop
