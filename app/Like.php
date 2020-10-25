<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    //Relationship
    public function user(){
        // いいねをしたユーザーの情報がわかる
        $this->belongsTo('App\User');
    }

    public function post(){
        // いいねがついた投稿の詳細がわかる
        $this->belongsTo('App\Post');
    }
}
