<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;

class CommentController extends Controller
{
    public function create(CreateComment $request, int $post_id)
    {
        $user_id = Auth::id();
        $post = Post::find($post_id);
        
        Comment::create([
            'comment' => $request->comment,
            'user_id' => $user_id,
            'post_id' => $post_id,
        ]);

        $comments = Comment::where('post_id', $post_id)->get();

        return view('posts.detail', [
            'post_id' => $post_id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function destroy(int $post_id, int $comment_id)
    {
        $comment = Comment::find($comment_id);
        $post = Post::find($post_id);
        $comment->delete();
        $comments = Comment::where('post_id', $post_id)->get();

        return view('posts.detail', [
            'post_id' => $post_id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function edit(Request $request, int $post_id, int $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->comment = $request->comment;
        $comment->save();

        $post = Post::find($post_id);
        $comments = Comment::where('post_id', $post_id)->get();

        return view('posts.detail', [
            'post_id' => $post_id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
