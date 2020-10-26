@extends('layout')

@section('content')

<div class="detail container">
    <div class="row">
        <div class="post-detail col-sm-12 row">
            <div class="col-sm-6">
                <div class="detail-left">
                    <div class="detail-user">
                        <img class="user-image" src="{{ secure_asset('storage/user_images/'.$post->user->user_image) }}">
                        <p class="post-user">{{ $post->user->name }}</p>
                    </div>
                    <p class="post-time">{{ $post->created_at }}</p>
                    <p class="post-content">{{ $post->content }}</p>
                </div>
            </div>
            <div class="col-sm-6 detail-right">
                <img class="detail-photo img-thumbnail" src="{{ secure_asset('storage/photos/'.$post->filename) }}" alt="投稿された画像">
            </div>
        </div>
        
        <div class="button-group col-sm-12 row">
            <div class="col-sm-10">
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
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-sm-2">
                @if(Auth::id() == $post->user_id)
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
                @endif
            </div>
        </div>

        <div class="comments col-sm-12 row">
            <ul class="col-sm-7">
                @if(isset($comments))
                    <?php $number=1; ?>
                    @foreach($comments as $comment)
                        <li class="row comments-repeat-row">
                            <hr>
                            <div class="comments-left col-sm-9">
                                <p>({{ $number }}) {{ $comment->user->name }}：{{ $comment->comment }}</p>
                                <form id="comment-edit-form-{{ $number }}" class="comment-edit-form" action="{{ route('comments.edit', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                                    <input type="text"  name="comment">
                                    <input type="submit" name="editComment" value="編集">
                                    @method('PATCH')
                                    @csrf
                                </form>
                            </div>
                            <div class="comments-right col-sm-3">
                                @if(Auth::id() == $comment->user_id)
                                    <form id="comment-delete-submit-{{ $number }}" class="comment-delete-submit" action="{{ route('comments.destroy', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                                        <input type="image" class="comment-delete" src="{{ secure_asset('storage/materials/delete.png') }}" alt="コメント削除ボタン">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <img id="comment-edit-{{ $number }}" class="comment-edit" src="{{ secure_asset('storage/materials/edit.png') }}" alt="コメント編集ボタン">
                                @endif
                            </div>
                        </li>
                        <?php $number++; ?>
                    @endforeach
                @endif
            </ul>
            <div class="col-sm-5">
                <form class="form-group comment-form" action="{{ route('comments.create', ['post_id' => $post->id]) }}" method="post">
                    <textarea class="form-control" name="comment" placeholder="コメントを入力..."></textarea>
                    <input class="btn btn-success" type="submit" value="送信">
                    @method('POST')
                    @csrf
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

<script>

</script>