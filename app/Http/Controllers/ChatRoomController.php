<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Log;
use Auth;
use App\ChatUser;
use App\ChatRoom;
use App\ChatJoin;
use App\ChatText;
use App\Services\ChatRoomService;

class ChatRoomController extends Controller
{   
    // join関数
    // 対象のchatroomが存在するかcheck
    // 対象のchatroomに入室済みcheck -> 入室済み -> show(chatroomを表示する関数)
    //                          入室していない -> どこにも入室していない入室し処理 -> chatroom 新規作成(joinテーブルに追加)
    //                                          別のchatRoomに入室している -> chatroom 更新処理(joinテーブル削除and追加)
    
    
    function join(request $req, $targetChatRoomId, ChatRoomService $chatRoomService){
        
        //自分がルームを作成している場合は、作成しない。作成していない。

        $targetChatRoom = ChatRoom::find($targetChatRoomId);
        
        //対象とするチャットルームが存在しない場合
        if(!$targetChatRoom){
            
            view('/');
        }

        
        
        //対象とするチャットルームが存在する場合
        $chatUser = Auth::user()->chatUser;
        //$join = ChatJoin::where('chat_user_id','=',$chatUser->chatJoin->chat_user_id)->first();
        //$join = $chatUser->chatJoin;
        //$chatRoomService = new ChatRoomService($chatUser);
        $chatRoomService->joinRoom($targetChatRoom);        

        return redirect()->route('chatroom.show');
    }

    function show(request $req){
        
        // chatroomにユーザー情報とテキストメッセージ情報を送る
        //dd("show");
        $chatUser = Auth::user()->chatUser;
        //chatRoom必要?
        //入室チャットルームメンバー一覧取得
        //$targtRoomJoins = $chatUser->chatRoom->chatJoins;
        // host退室時には、guestのchatJoinも削除済みのため
        if(!$chatUser->chatJoin){
            return redirect()->route("home");
        }
        $chatRoom = $chatUser->chatJoin->chatRoom;
        
        
        $members = $chatRoom->chatJoins;
        
        // $chatMessages = $chatUser->chatJoin->chatRoom->chatTexts;
        //dd($targtRoomJoins);
        // $members = $targtRoomJoins->map(function($join){
        //     return $join->chatUser;
        // });
        
        // foreach($chatMembers0 as $member){
        //     echo "nickname:";
        //     echo($member->nickname);
        //   }
        // echo($chatMembers0);
        //紐づいているかどうかどうやってみる・
        
        
        $isHost = $chatUser->chatJoin->isHost();

        return view('chatroom', [
            'chatUser' => $chatUser,
            'isHost' => $isHost,
            'room' => $chatUser->chatJoin->chatRoom,
            'members' => $members,
            // 'messages' => $chatMessages,
            // amend hostの時しか、offerになれない設定。将来的には変える必要ある？
            // answer側でstart押してからでも開始できるから問題ない。
            // answer側でstart

            'connectionType' => ($isHost) ? "offer" : "answer"
        ]);
    }

    function message(request $req){
        
        $message = $req->input("message");
        
        if(!$message){
            return redirect()->route("chatroom.show");
        }
        //joinが無かった場合の処理を書くべき

        $chatUser = Auth::user()->chatUser;
        
        ChatText::create([
            "chat_room_id" => $chatUser->chatJoin->chat_room_id,
            "chat_user_id" => $chatUser->chatJoin->chat_user_id,
            "message" => $message
        ]);
        
        return redirect()->route("chatroom.show");
        // DBからメッセージ取得
        
    }

    function create(){
        
        $chatUser = Auth::user()->chatUser;

        //activeなchatroomに対しての判定は未実装。
        $openRoom = $chatUser->openRoom();
        
        if($openRoom){
            
            return redirect()->route("home");
        }

        ChatRoom::create([
            "room_name" => $chatUser->nickname . "'s room",
            "chat_user_id" => $chatUser->id,
            "room_status" => "open"
        ]);

        return redirect()->route('home');

    }

    //chatroomから非公開化
    //chatJoinからレコード削除
    function leave(){
        
        $chatUser = Auth::user()->chatUser;
        // dd($chatUser->openRoom());
        // //activeなchatroomに対しての判定は未実装。???
        // if(!$chatUser->openRoom()){
        //     return redirect()->route("home");
        // }
    
    $joinType = $chatUser->chatJoin->join_type;
        
    if( $joinType == "host"){
        // ホストが退室したら→（存在すれば）ゲストも退室

        // amend guestが存在するかどうかのメソッドを追加したい
        
        if($gusetJoin=$chatUser->chatJoin->chatRoom->chatJoins->where('join_type','=','guest')->first()){
            $gusetJoin=$chatUser->chatJoin->chatRoom->chatJoins->where('join_type','=','guest')->first()->delete();
        }

        
        // chatjoin guestのレコード削除
        $chatUser->chatJoin->delete();

        $chatUser->openRoom()->update([
            "room_status" => "close"
        ]);
    }    
    else if ( $joinType == "guest"){
        // ゲストが退室→ゲストが退室
        // chatjoin guestのレコード削除
        $chatUser->chatJoin->delete();

    }else{
        // amend エラーの場合の処理
    }
    
        

        return redirect()->route('home');

    }
}
