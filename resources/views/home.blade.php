@extends('layout')

@section('content')

<div class="container">
    @foreach($posts as $post)
        <div class="post-content">
            <a class="post-link" href="{{ route('posts.detail', ['post_id'=>$post->id])}}">
                <img class="post-photo img-thumbnail" src="storage/photos/{{ $post->filename }}" alt="投稿した画像">
                <div class="post-info">
                    <img class="info-user-image" src="{{ asset('storage/user_images/'.$post->user->user_image) }}">
                    <p class="info-user-name"><span style="font-size: 20px; font-weight: 900;">{{ $post->user->name }}</span> ({{ $post->created_at }})</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
    
@endsection