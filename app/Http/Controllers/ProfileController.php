<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ChatUser;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // react api用
    public function show(){

        $user= Auth::user();
        return response()->json([
            "result" => 1,
            "user" => $user,
            "chat_user" => ($user->chatUser)? $user->chatUser : null,
            "profile_link" => route("user.show", $user->id)
        ]);
    }

    // react api用
    public function update(request $req){
        
        $update = $req->input("chat_user");
        
        $chatUser = Auth::user()->chatUser;

        if(!$chatUser){

            ChatUser::create([
                "user_id" => Auth::user()->id,
                "nickname" => $update["nickname"],
                "age" => $update["age"]
            ]);

            return response()->json([
                "result" => 1
            ]);
        }

        if($update["nickname"] && $update["nickname"] != $chatUser->nickname)
            $chatUser->nickname = $update["nickname"];

        if($update["age"] && $update["age"] != $chatUser->age) 
            $chatUser->age = $update["age"];
        
        $chatUser->save();
        
        return response()->json([
            "result" => 1
        ]);
    }
}
