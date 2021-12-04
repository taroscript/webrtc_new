<?php

use Illuminate\Support\Facades\Route;
use App\ChatRoom;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if(config('app.env') === 'staging'){
	URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

//テストページ：modelの動作確認用
Route::get('/test',
    function () {
        return view('test', [
        'all_rooms' => ChatRoom::all()
    ]);
});

//テストページ：charoomを表示
Route::get('/test2',
    function () {
        
        return view('chatroom');
    });

Route::get('/u/{id}',function($id){
    $user = \App\User::find($id);
    return response()->json([
    "user" => $user,
    "chatUser" => \App\ChatUser::where("user_id","=",$user->id)->first()
    ]);
});    

//テストページ：charoomを表示
Route::get('/test3','ChatRoomController@show');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// chat部屋表示
Route::get('/chatroom/chatroom','ChatRoomController@show')->name('chatroom.show');
Route::get('/chatroom/{chat_room_id}/join', 'ChatRoomController@join')->name('chatroom.join');
Route::post('chatroom/','ChatRoomController@message')->name('chatroom.message');
Route::get('chatroom/leave','ChatRoomController@leave')->name('chatroom.leave');
Route::get('chatroom/api/create', 'ChatRoomController@create')->name('chatroom.create');


Route::post('api/chatroom/message', 'ChatRoomApiController@message')->name('api.chatroom.message');
//Route::get('/chatroom/{room_id}/join','ChatRoomController@join')->name('chatroom.join');
Route::get('chatroom/api/{id}/join','ChatRoomApiController@join')->name('api.chatroom.join');

Route::get('api/chatroom/Video/info', 'ChatRoomApiController@videoInfo')->name('api.chatroom.videoInfo');
Route::post('api/chatroom/video/start', 'ChatRoomApiController@videoStart')->name('api.chatroom.video.start');
Route::post('api/chatroom/video/end', 'ChatRoomApiController@videoEnd')->name('api.chatroom.video.end');
Route::post('api/chatroom/video/update_sdp', 'ChatRoomApiController@updateSdp')->name('api.chatroom.update_sdp');

//test api
Route::get('test/api', 'ChatRoomApiController@test_api')->name('test.api');

// createProfile
// debug:強制的にチャットユーザー作成
Route::get('chatroom/profile', 'HomeController@createProfile')->name('create.profile');
// Route::get('/u/{id}', function($id){
//     $user= Auth::user();
//     return response()->json([
//         "user" => $user,
//         "chat_user" => $user->chatUser,
//         "profile_link" => route("user.show", $user->id)
//     ]);
// })->name('user.show');

Route::get('/u/{id}', 'ProfileController@show')->name('user.show');

Route::get('profile', function(){
    return view('profile');
});

// reactでhome画面を作る前にlaravelでbladeの画面を確かめる用
Route::get('/bladesample', function () {
    return view('bladesample');
});

// reactでchat画面を作る前にlaravelでbladeの画面を確かめる用
Route::get('/chatroomsample', function () {
    return view('chatroomsample');
});

// profile react
Route::post('profile/update', 'ProfileController@update')->name('user.update');

Route::get('/sampleprofile', function () {
    return view('sampleprofile');
})->middleware("auth");

// 2021/11/09 api reactからchatroom api
Route::get('/samplechatroom', function () {
    return view('samplechatroom');
})->middleware("auth");
Route::get('api/chatroom/getTexts', 'ChatRoomApiController@getTexts')->name('api.chatroom.getTexts');
Route::post('api/chatroom/updateTexts', 'ChatRoomApiController@updateTexts')->name('api.chatroom.updateTexts');
