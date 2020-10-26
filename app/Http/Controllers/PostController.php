<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\File;

class PostController extends Controller
{

    public function show()
    {
        $posts = Post::all();
        return view('home', [
            'posts' => $posts,
            ]);
    }

    public function showMyPosts(int $user_id)
    {
        $posts = Post::where('user_id', $user_id)->get();
        return view('posts.myposts',[
            'posts' => $posts,
            'user_id' => $user_id,
        ]);
    }

    public function detail(int $post_id)
    {
        $post = Post::find($post_id);
        $comments  = Comment::where('post_id', $post_id)->get();
        
        return view('posts.detail', [
            'post_id' => $post->id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function showUploadForm()
    {
        return view('posts.upload');
    }

    public function upload(Request $request)
    {
        // 画像のバリデーションチェックと画像ファイルかどうか
        $file = $request->file('photo')->getClientOriginalName();
        $content = $request['content'];

        $filename = pathinfo($file, PATHINFO_FILENAME);
        $uni_filename = uniqid($filename, true);
        $extension = $request->file('photo')->getClientOriginalExtension();

        $uni_file = $uni_filename.".".$extension;

        // 画像本体の保存
        $request->file('photo')->storeAS('photos', $uni_file);

        //画像と内容をデータベースに保存する
        $post = Post::create([
            'content' => $content,
            'filename' => $uni_file,
            'user_id' => Auth::id(),
        ]);
        
        return redirect('/');
    }

    public function destroy(int $post_id)
    {
        $post = Post::find($post_id);
        $filePath = storage_path().'/app/public/photos/'.$post->filename;
        // 画像自体の削除
        \File::delete($filePath);
        if (\File::exists($filePath)){
            return '投稿を削除できませんでした！';
        }else{
            $post->delete();
            return redirect('/');
        }
    }

    public function showEditForm(int $post_id)
    {
        $post = Post::find($post_id);
        return view('posts.edit',[
            'post' => $post,
        ]);
    }

    public function edit(Request $request, int $post_id)
    {
        $post = Post::find($post_id);

        if(isset($request['photo'])){
            // 画像を削除してからアップロード
            $filePath = storage_path().'/app/public/photos/'.$post->filename;
            \File::delete($filePath);

            if (\File::exists($filePath)){
                return '投稿を削除できませんでした！';
            }else{
                $file = $request->file('photo')->getClientOriginalName();
    
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $uni_filename = uniqid($filename, true);
                $extension = $request->file('photo')->getClientOriginalExtension();
    
                $uni_file = $uni_filename.".".$extension;
                $request->file('photo')->storeAs('photos', $uni_file);

                $post->content = $request->content;
                $post->filename = $uni_file;
                $post->save();

                return view('posts.detail', [
                    'post_id' => $post_id,
                    'post' => $post,
                ]);
            }
            
        }else{
            // 画像の更新はせずにアップロード
            $post->contents = $request->contents;
            $post->save();
            return view('posts.detail', [
                'post_id' => $post_id,
                'post' => $post,
            ]);
        }
    }

    
}
