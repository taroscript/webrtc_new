<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    
    protected $fillable =[
        "room_name","chat_user_id","room_status"
    ];
    
    public function chatJoins(){
        return $this->hasMany(
            'App\ChatJoin',
            'chat_room_id',
            'id'
            );
    }

    public function chatTexts(){
        return $this->hasMany(
            'App\ChatText',
            'chat_room_id',
            'id'
            );
    }

    public function chatUser(){
        return $this->belongsTo('App\ChatUser');
    }

    public function owner(){

        return $this->belongsTo(
            'App\ChatUser',
            'chat_user_id',
            'id'
        );
    }

    public function closeRoom(){

        $this->room_status = "close";
        $this->save();
        
        $this->chatJoins()->each(function($join){
            
            $join->delete();
        });
    }




    public function addMember(ChatUser $chatUser){
        
        $chatJoin = $chatUser->chatJoin;
        if($chatJoin && $chatJoin->room_id == $this->id){
            return;
        }

        $chatUser->chatJoin()->delete();

        ChatJoin::create([
            "room_id" => $this->id,
            "chatuser_id" => $chatUser->id
        ]);
    }
}
