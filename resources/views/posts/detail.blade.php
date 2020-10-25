@extends('layout')

@section('content')

<div class="detail container sm">
    <div class="post-detail">
        <div class="row">
            <div class="col-sm-6">
                <div class="detail-left">
                    <div class="detail-user">
                        <img class="user-image" src="{{ asset('storage/user_images/'.$post->user->user_image) }}">
                        <p class="post-user">{{ $post->user->name }}</p>
                    </div>
                    <p class="post-time">{{ $post->created_at }}</p>
                    <p class="post-content">{{ $post->content }}</p>
                </div>
            </div>
            <div class="col-sm-6 detail-right">
                <img class="detail-photo img-thumbnail" src="{{ asset('storage/photos/'.$post->filename) }}" alt="投稿された画像">
            </div>
        </div>

        <div class="button-group">
            <div class="like-button">
                @if($post->is_liked_by_auth_user($post->user_id))
                    <form action="{{ route('like.delete',['post_id' => $post->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">いいね!</button>
                    </form>
                    <p>{{ $post->likes->count() }}回「いいね！」されました</p>
                @else
                    <form action="{{ route('like.create', ['post_id' => $post->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-secondary">いいね!</button>
                    </form>
                    <p>{{ $post->likes->count() }}回「いいね！」されました</p>
                @endif
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="other-button">
                <form action="{{ route('posts.destroy', ['post_id' => $post->id]) }}" method="post">
                    <input class="btn btn-danger" type="submit" value="削除">
                    @method('DELETE')
                    @csrf
                </form>
                <form action="{{ route('posts.showEditForm', ['post_id' => $post->id]) }}" method="post">
                    <input class="btn btn-primary" type="submit" value="編集">
                    @method('POST')
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="comments">
        <h2>コメント</h2>
        <div class="row">
            <div class="col-sm-6">
                @if(isset($comments))
                    <?php $number=1; ?>
                    @foreach($comments as $comment)
                        <hr>
                        <p>({{ $number }}) {{ $comment->user->name }}：{{ $comment->comment }}</p>
                        <?php $number++; ?>
                        @if(Auth::id() == $comment->user_id)
                            <img id="comment-delete" src="{{ asset('storage/materials/delete.png') }}" alt="コメント削除ボタン">
                            <form id="comment-delete-submit" action="{{ route('comments.destroy', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                                @method('DELETE')
                                @csrf
                            </form>

                            <img id="comment-edit" src="{{ asset('storage/materials/edit.png') }}" alt="コメント編集ボタン">
                            <div id="comment-edit-form">
                                <form action="{{ route('comments.edit', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                                    <input type="text"  name="comment">
                                    <input type="submit" name="editComment" value="編集">
                                    @method('PATCH')
                                    @csrf
                                 </form>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="col-sm-6">
                <form class="form-group comment-form" action="{{ route('comments.create', ['post_id' => $post->id]) }}" method="post">
                    <textarea class="form-control" name="comment" placeholder="コメントを入力..."></textarea>
                    <input class="btn btn-success" type="submit" value="送信">
                    @method('POST')
                    @csrf
                </form>
            </div>
        </div>
    </div>

<script>
    document.getElementById("comment-delete").onclick = function(){
        document.getElementById("comment-delete-submit").submit();
    };

</script>
@endsection
