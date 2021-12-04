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
    

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/chatroom/chatroom','ChatRoomController@show')->name('chatroom.show');

Route::get('/chatroom/{room_id}/join','ChatRoomController@join')->name('chatroom.join');



