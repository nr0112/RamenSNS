@extends('layout')

@section('content')

<h1>プロフィール</h1>
<img class="user-image" src="{{ asset('storage/user_images/'.Auth::user()->user_image) }}">
<p>{{ Auth::user()->name }}</p>
<p>{{ Auth::user()->email }}</p>

<!-- ユーザー名の変更も追加 -->

<h2>プロフィール画像の変更</h2>
<form action="{{ route('users.edit', ['user_id' => Auth::user()->id]) }}" method="post" enctype="multipart/form-data">
  @method('PATCH')
  @csrf
  <label for="user_image">プロフィール画像</label>
  <input type="file" name="user_image">
  <input type="submit" value="変更">
</form>

@endsection