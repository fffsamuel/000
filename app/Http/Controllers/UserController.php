<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function store(Request $request){
        $user_avatar = $this->manageAvatar($request);
        $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'name' => $request->user_name,
                'email' => $request->user_email,
                'avatar' => $user_avatar
            ]
            );
        return $user->id;
    }    

    public function manageAvatar(Request $request){
        if(!is_null($request->user_avatar)){
            if($request->avatar != \Config::get('constants.avatar_name')){
                Storage::delete(\Config::get('constants.avatar_path_save') . $request->avatar);
            }
            $user_avatar = time() . '.' . $request->user_avatar->getClientOriginalExtension();
            $img = \Image::make($request->user_avatar)->resize(234, 222);
            $img->stream();
            Storage::put(\Config::get('constants.avatar_path_save') . $user_avatar, $img);
        }else{
            if($request->avatar == \Config::get('constants.avatar_name')){
                $user_avatar = NULL;
            }else {
                $user_avatar = $request->avatar;
            }
        }
        return $user_avatar;
    }

    public function deleteAvatar(Request $request){
        if(isset($request)){
            if($request->avatar != \Config::get('constants.avatar_name')){            
                Storage::delete(\Config::get('constants.avatar_path_save') . $request->avatar);
                $user = User::find($request->id);
                $user->avatar = null;
                $user->save();
                return response('Usuário ' . $user->name . ' atualizado', 200);
            }
            return response('Já é a foto padrão!', 200);
        }
        return response('Algo deu errado', 404);
    }

}