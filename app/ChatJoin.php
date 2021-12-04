<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatJoin extends Model
{
    protected $fillable = [ 
        'chat_user_id', 
        'chat_room_id',
        'video_status',
        'join_type',
        'offer_sdp',
        'answer_sdp'
    ];
    
    public function chatTexts(){
        return $this->hasmany('App\ChatRoom');
    }

    public function chatRoom(){
        return $this->belongsTo('App\ChatRoom');
    }

    public function chatUser(){
        return $this->belongsTo(
            'App\ChatUser',
            'chat_user_id',
            'id');
    }

    public function isHost(){
        return $this->join_type == "host";
    }
}
