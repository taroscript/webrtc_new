<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatText extends Model
{
    
    protected $fillable = ['chat_user_id', 'chat_room_id', 'message'];
    
    public function chatJoin(){
        return $this->belongsTo('App\ChatJoin');
    }

    public function chatUser(){
        return $this->belongsTo('App\ChatUser');
    }
}
