@extends('layout')

@section('content')
        <form action="{{ route('posts.edit', ['post_id'=> $post->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <label for="title">画像</label>
            <!-- old関数で直前の入力値を引き出す→ない場合は第2引数で$task->titleを引き出す -->
            <input type="file" name="photo" value="{{ $post->filename }}" />
            <label for="contents">内容</label>
            <input type="text" name="content" value="{{ $post->contents }}">
            <button type="submit">送信</button>
        </form>

@endsection