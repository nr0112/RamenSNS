<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comment'];

    //Relationship
    public function user(){
        // いいねをしたユーザーの情報がわかる
        return $this->belongsTo('App\User');
    }

    public function post(){
        // いいねがついた投稿の詳細がわかる
        return $this->belongsTo('App\Post');
    }
}
