@extends('layout')

@section('content')

    <a class="btn btn-success" href="{{ route('posts.showUploadForm') }}">投稿する</a>
    <div class="mypost">
        <img src="{{ secure_asset('storage/materials/ramen1.png') }}" alt="ラーメンのシルエット">
        <h1>{{ Auth::user()->name }}さんの投稿</h1>
    </div>

    <div class="container">
        @foreach($posts as $post)
            <div class="post-content">
                <a class="post-link" href="{{ route('posts.detail', ['post_id'=>$post->id])}}">
                    <img class="post-photo img-thumbnail" src="{{ seccure_asset('storage/photos/'.$post->filename) }}" alt="投稿した画像">
                    <div class="post-info">
                        <img class="info-user-image" src="{{ seccure_asset('storage/user_images/'.$post->user->user_image) }}">
                        <p class="info-user-name"><span style="font-size: 20px; font-weight: 900;">{{ $post->content }}</span> ({{ $post->created_at }})</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
        
@endsection