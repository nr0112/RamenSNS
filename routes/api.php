<?php

// use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ユーザー認証必須
Auth::routes();

Route::view('/setting', 'setting')->name('toSettingPage');
Route::patch('/setting/{user_id}', 'UserController@edit')->name('users.edit');

// 画像と内容のアップロード
Route::get('/posts', 'PostController@showUploadForm')->name('posts.showUploadForm');
Route::post('/posts', 'PostController@upload')->name('posts.upload');

Route::delete('/posts/{post_id}', 'PostController@destroy')->name('posts.destroy');

Route::post('/posts/{post_id}', 'PostController@showEditForm')->name('posts.showEditForm');
Route::patch('/posts/{post_id}', 'PostController@edit')->name('posts.edit');

Route::get('/posts/{post_id}', 'PostController@detail')->name('posts.detail');

Route::get('/myposts/{user_id}', 'PostController@showMyPosts')->name('posts.myposts');

//like
Route::put('/posts/{post_id}/like', 'LikeController@create')->name('like.create');
Route::delete('/posts/{post_id}/like', 'LikeController@destroy')->name('like.delete');

//comments
Route::post('/posts/{post_id}/comments', 'CommentController@create')->name('comments.create');
Route::delete('/posts/{post_id}/comments/{comment_id}', 'CommentController@destroy')->name('comments.destroy');
Route::patch('/posts/{post_id}/comments/{comment_id}', 'CommentController@edit')->name('comments.edit');

