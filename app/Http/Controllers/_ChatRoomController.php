<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    function join(Request $req, $id){

        // $room = ChatRoom::find($id);
        // $room->addMember(Auth::user()->chatUser);
        // return redirect("/test");
        // echo route('chatroom.join', ["room_id" => $join->room_id]);
        // exit;
        
        //もしjoinがなければ、作る。あれば、入る
        dd($id);
        $join = ChatJoin::where("chat_room_id", "=", "1")->first();

        if(!$join){
            $join = ChatJoin::create([
                'chat_user_id' => $user->id,
                'chat_room_id' => $chat_room->id
            ]);
        }

        return redirect("/test");
    }

    function show(Request $req){
        return view('chatroom');
    }
}
