<?php
namespace App\Services;

use App\ChatUser;
use App\ChatJoin;
use App\ChatRoom;

class ChatRoomService {

  //private $chatUser;

  function __construct(ChatUser $chatUser){
    $this->chatUser = $chatUser;
  }

  // 対象のchatroomに入室済みcheck -> 入室済み -> show(chatroomを表示する関数)
  //                          入室していない -> どこにも入室していない入室し処理 -> chatroom 新規作成(joinテーブルに追加)
  //                                          別のchatRoomに入室している -> chatroom 更新処理(joinテーブル削除and追加)

  public function joinRoom(ChatRoom $targetChatRoom){

    $chatUser = $this->chatUser;
    $chatJoin = $chatUser->chatJoin;
    
    // 既にどこかのチャットルームに入っているか判定
    // どのチャットルームにも入っていない場合
    // if(!$chatJoin){
        
    //     $chatJoin = ChatJoin::create([
    //         'chat_user_id' => $chatUser->user_id,
    //         'chat_room_id' => $targetChatRoom->id
    //     ]);
    
    // // 既にチャットルームに入っている場合、対象チャットルームでなければ、更新処理
    // }else

    $values =[
      'chat_user_id' => $chatUser->user_id,
      'chat_room_id' => $targetChatRoom->id,
      'video_status' => false,
      'join_type'  => ($targetChatRoom->owner->id == $chatUser->id) ? "host" : "guest",
      'offer_sdp'  => null,
      'answer_sdp'  => null
    ];

    if(!$chatJoin){
      $chatJoin=ChatJoin::Create($values);
    }else if(!$chatJoin->chat_room_id != $targetChatRoom->id){
      $chatJoin->update($values);                    
    }

    //部屋主が別のルームにjoinした時、部屋のclose処理
    $openRoom =$chatUser->OpenRoom();
    
    if($openRoom && $openRoom->id != $targetChatRoom->id ){
      
      $openRoom->closeRoom();
      
    }
    
    return $chatJoin;
  }
}