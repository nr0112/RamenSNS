@extends('layout')

@section('content')

    <form action="{{ route('posts.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo">
        <input type="text" name="content">
        <input type="submit" name="submit">
    </form>
    
@endsection