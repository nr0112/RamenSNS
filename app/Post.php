<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 主キーを設定
    protected $primaryKey = 'id';

    /**
     * 複数代入する属性
     * 
     * @var array
     */
    protected $fillable = ['content', 'filename', 'user_id'];

    //Relationship
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function likes(){
        return $this->hasMany('App\Like');
    }

    // その投稿がすでにいいねされているかどうかの判断
    public function is_liked_by_auth_user($user_id)
    {
        $like_users = array();
        // この投稿のlikeを取得
        foreach($this->likes as $like){
            array_push($like_users, $like->user_id);
        }
        if (in_array($user_id, $like_users)){
            return true;
        }else{
            return false;
        }
    }


}
