<?php

use Illuminate\Database\Seeder;
use App\User;
use App\ChatUser;
use App\ChatRoom;
use App\ChatJoin;
use App\ChatText;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        
        // 目的
        // 任意のユーザーがルームを作成し、ルームに入室した状態を作り出す。ルームには作成者しかいない。

        $user_name = 'test2';
        $user_email = $user_name . '@test.com';
        $user_password = 'password';
        
        //joinテーブルを作りたい
        //　echo $user_name,"\n",$user_id,"\n",$user_email,"\n",$user_password;
        
        

        //users
        $user = User::where('email', '=', $user_email)->first();
        //$user = User::where('email','=','test@test.com')->first();
        
        if(is_null($user)){
            $user = User::create([
                'name'=> $user_name,
                'email'=> $user_email,
                'password' => bcrypt($user_password)
            ]);
            echo 'user登録完了:'.$user_email,"\n";
        }
        
        $chatUser = $user->chatUser;
        $user_count = ChatUser::all()->count();

        if(is_null($chatUser)){
            $chatUser = ChatUser::create([
                'nickname'=>'chatter_'.$user_name.'_'.$user_count,
                'age'=>'30',
                'user_id' => $user->id
            ]);
            echo 'chatuser登録完了:'.$chatUser->nickname,"\n";
        }

        //chat_rooms
        //chatRoomっリレーションメソッド名だよね？
        // $chatRoom = $chatUser->chatRoom;
        
        // if(is_null($chatRoom)){
            
        //     $chatRoom= ChatRoom::create([
        //         // nameを自動的に変えたい。
        //         'room_name' => $chatUser->nickname."'s room",
        //         'chat_user_id' => $chatUser->id,
        //         'room_status' => 'open'
        //     ]);
        //     echo 'chatRoom登録完了:'.$chatRoom->room_name,"\n";
        // }

        //chat_joins
        //どうやってchatRoomからjoinsにデータを入れる？
        // $chatJoins = $chatRoom->chatJoins;
        // $chatRoom_count = $chatRoom->count();

        // if($chatJoins->isEmpty()){
            
        //     $chatJoin = ChatJoin::create([
        //         'chat_room_id' => 1,
        //         'chat_user_id' => $chatUser->id
        //     ]);
        //     echo 'chatJoin登録完了:'.$chatJoin,"\n";
        // }

        //$chatUser->chatjoin
        // $chatJoin = $chatUser->chatJoin;
        // echo $chatUser->id.'\n';
        // echo $chatRoom;
        // if(!$chatJoin){
        //     $chatJoin = ChatJoin::create([
        //         'chat_user_id' => $chatUser->id,
        //         'chat_room_id' => $chatRoom->id
        //     ]);
        // }

        
        // $chatTexts = $chatUser->chatRoom->chatTexts;
        
        // $chatText = ChatText::create([
        //     'chat_room_id' => $chatRoom->id,
        //     'chat_user_id' => $chatUser->id,
        //     'message' => 'testetest'
        // ]);
        

    }
}
