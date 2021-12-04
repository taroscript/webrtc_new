<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    
    protected $fillable = ['user_id', 'nickname', 'age'];

    public function chatRooms(){
        return $this->hasMany('App\ChatRoom');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function chatJoin(){
        return $this->hasOne('App\ChatJoin');
    }

    public function chatTexts(){
        return $this->hasMany('App\ChatText');
    }

    public function openRoom(){
        // これだと3回呼び出される？？？
        logger("openRoom()");
        if($this->chatRooms()){
            return $this->chatRooms()->where("room_status","=","open")->first();
        }
        return;

    }
}
