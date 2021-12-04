<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ChatRoom;
use App\ChatText;
use App\ChatUser;
use App\Services\ChatRoomService;

use Illuminate\Support\Facades\DB;


class ChatRoomApiController extends Controller
{
    function createRoom(ChatRoomService $chatRoomService){

        //新規ルームを作成
        //自身作成のルームがあるかcheck
        //chatRoom更新
        //chaJoin更新

    }
    function join(request $req, $targetChatRoomId, ChatRoomService $chatRoomService){
        
        //自分がルームを作成している場合は、作成しない。この処理はまだ作らない。

        $targetChatRoom = ChatRoom::find($targetChatRoomId);
        
        //対象とするチャットルームが存在しない場合
        if(!$targetChatRoom){
            
            view('/');
        }
        
        $chatJoin = $chatRoomService->joinRoom($targetChatRoomId);
        //対象とするチャットルームが存在する場合
        // $chatUser = Auth::user()->chatUser;
        //$join = ChatJoin::where('chat_user_id','=',$chatUser->chatJoin->chat_user_id)->first();
        // $join = $chatUser->chatJoin;
        
        // if(!$join){
            
        //     $join = ChatJoin::create([
        //         'chat_user_napme' => $chatUser->chatJoin->chat_user_id,
        //         'chat_room_id' => $targetChatRoomId
        //     ]);

        // }elseif(!$join->chat_room_id != $targetChatRoomId){
            
        //     $join->update([
        //         'chat_room_id' => $targetChatRoomId,
        //         'chat_user_id' => $chatUser->chatJoin->chat_user_id               
        //     ]);
            
        //return redirect()->route('chatroom.show');
        return response()->json([
            "result" => 1,
            "json" => $chatJoin
        ]);
    }
    function getTexts(){

        $chatUser = Auth::user()->chatUser;
        $chat_room_id = $chatUser->chatJoin->chatRoom->id;
        
        
        
        $texts = DB::select('select b.nickname, b.isMe, a.message, a.created_at 
        from chat_texts a left join (
            select x.id, x.nickname, IF(y.id, true, false) as isMe from chat_users x left join (
                select * from chat_users z where z.id = :me_id) y 
                on x.id = y.id) b on a.chat_user_id = b.id 
        where chat_room_id = :id1 order by a.created_at desc', ['id1' => $chat_room_id, 'me_id' => $chatUser->id]);
        
        
        return response()->json([
            "result" => 1,
            "texts" => $texts
        ]);
    }

    public function updateTexts(request $req){
        
        $updateTexts = $req->input("message");
        $chatUser = Auth::user()->chatUser;
        
        if($updateTexts){
            
        
            ChatText::create([
            "chat_room_id" => $chatUser->chatJoin->chat_room_id,
            "chat_user_id" => $chatUser->id,
            "message" => $updateTexts
            ]);
        }
        
        
        
        $chat_room_id = $chatUser->chatJoin->chatRoom->id;
        $texts = DB::select('select b.nickname, b.isMe, a.message, a.created_at 
        from chat_texts a left join (
            select x.id, x.nickname, IF(y.id, true, false) as isMe from chat_users x left join (
                select * from chat_users z where z.id = :me_id) y 
                on x.id = y.id) b on a.chat_user_id = b.id 
        where chat_room_id = :id1 order by a.created_at desc', ['id1' => $chat_room_id, 'me_id' => $chatUser->id]);
       
        
        return response()->json([
            "result" => 1,
            "texts" => $texts
        ]);
    }

    function message(request $req){
        
        $message = $req->input("message");
        
        if(!$message){
            return redirect()->route("chatroom.show");
        }
        //joinが無かった場合の処理を書くべき

        $chatUser = Auth::user()->chatUser;
        
        $chatText = ChatText::create([
            "chat_room_id" => $chatUser->chatJoin->chat_room_id,
            "chat_user_id" => $chatUser->chatJoin->chat_user_id,
            "message" => $message
        ]);
        
        //return redirect()->route("chatroom.show");
        return response()->json([
            "result" => 1,
            "message" => $chatText
        ]);
        // DBからメッセージ取得
        
    }

    function videoStart(){

        $chatUser = Auth::user()->chatUser;
        $openRoom = $chatUser->openRoom();
        dd($openRoom);
        if($chatUser->id == $openRoom->owner->chat_user_id){
            $openRoom->video_status = true;
            $openRoom->save();
        }

        return response()->json([
            "resut" => 1,
            "video_status" => $openRoom->video_status
        ]);
    }
    function videoEnd(){

        $chatUser = Auth::user()->chatUser;
        $openRoom = $chatUser->openRoom();
        
        if($chatUser->id == $openRoom->owner->id){
            $openRoom->video_status = false;
            $openRoom->save();
        }

        return response()->json([
            "resut" => 1,
            "video_status" => $openRoom->video_status
        ]);
    }

    function updateSdp(request $req){
        
        $sdp = $req->input("sdp");

        if(!$sdp){
            return abort(500);
        }

        $chatUser = Auth::user()->chatUser;
        $chatJoin = $chatUser->chatJoin;
        $chatRoom = $chatJoin->chatRoom;
        
        if($chatJoin->isHost()){
            $chatJoin->offer_sdp = $sdp;
        }else{
            $chatJoin->answer_sdp = $sdp;
        }
        $chatJoin->save();

        return response()->json([
            "result" => 1,
            "chatRoom" => $chatRoom,
            "chatJoin" => $chatJoin
        ]);
        
    }

    // debug用
    function videoInfo(){

        $chatUser = Auth::user()->chatUser;
        
        $chatJoin = $chatUser->chatJoin;
        $chatRoom = $chatJoin->chatRoom;
        
        //amend 三人以上の場合修正が必要
        // 侍コードは?
        $guestJoin = $chatRoom->chatJoins()->where("join_type","=","guest")->first();
        $hostJoin =$chatRoom->chatUser->chatJoin;

        return response()->json([
            "result" => 1,
            "chatRoom" => $chatRoom,
            "chatJoin" => $chatJoin,
            "host" =>$chatRoom->owner,
            //guestが複数人未対応
            "guest" =>($guestJoin) ? $guestJoin->chatUser : null,
            "host_join" => ($hostJoin) ? $hostJoin : null,
            "guest_join" => ($guestJoin) ? $guestJoin : null
        ]);

    }

    function test_api(){

        $chatUser = auth::user()->chatUser;
        $chatJoin = $chatUser->chatJoin;

        return response()->json([
            "result" => 1,
            "chatJoin" => $chatJoin
        ]);
    }


}
