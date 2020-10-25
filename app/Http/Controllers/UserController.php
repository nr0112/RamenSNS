<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function edit(Request $request, int $user_id)
    {
        $user = User::find($user_id);
        if(isset($request['user_image'])){
            // 過去の画像
            $filePath = storage_path().'/app/public/user_images/'.$user->user_image;

            if(\File::exists($filePath)){
                \File::delete($filePath);
            }

            $image = $request->file('user_image')->getClientOriginalName();
            $imagename = pathinfo($image, PATHINFO_FILENAME);
            $uni_imagename = uniqid($imagename, true);
            $extension = $request->file('user_image')->getClientOriginalExtension();
            $uni_image = $uni_imagename.".".$extension;
            $request->file('user_image')->storeAs('user_images', $uni_image);
            $user->user_image = $uni_image;
            $user->save();
            return 'プロフィール画像を変更しました！';
        }
    }
}
