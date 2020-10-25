<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Like;
use App\Comment;

class LikeController extends Controller
{
    // only()の引数内のメソッドはログイン時のみ有効
    // あとでapiに記述し直す
    public function __construct()
    {
      $this->middleware(['auth', 'verified'])->only(['like', 'unlike']);
    }

    public function create(int $post_id){
 
        $user_id = Auth::id();
        
        $like = Like::create([
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);

        $post = Post::find($post_id);
        $comments  = Comment::where('post_id', $post_id)->get();

        return view('posts.detail', [
            'post_id' => $post->id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function destroy(int $post_id){
        // いいねをはずすとき(2回目のいいね)の処理
        $user_id = Auth::id();
        $like = Like::where('post_id', $post_id)->where('user_id', $user_id)->first();
        $like->delete();

        $post = Post::find($post_id);
        $comments  = Comment::where('post_id', $post_id)->get();

        return view('posts.detail', [
            'post_id' => $post->id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
