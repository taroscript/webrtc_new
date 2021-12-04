<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ChatRoom;
use App\ChatUser;
use App\User;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        //dd(Auth::user()->chatUser->chatRooms()->where("room_status","=","open")->first());
        $chatUser = Auth::user()->chatUser;
        if($chatUser){
            
        
            return view('home', [
            "chatRooms" => ChatRoom::all()->where("room_status","=","open"),
            "chatUserOwn" => $chatUser,
            "openChatRoom" =>$chatUser->openRoom()
        ]);
        }
        
        return view('profile');
    }

    // debug to force to create ChatUser
    public function createProfile(){

        $user = Auth::user();
        
        ChatUser::create([
            "nickname" => $user->name,
            "age" => 30,
            "user_id" => $user->id
        ]);
    }
}
