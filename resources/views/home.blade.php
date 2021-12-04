@extends('layouts.app')

@section('content')
@if(App::environment(['local']))
<script src="{{ asset('/webrtcreact/static/js/2.chunk.js') }}"></script>
<script src="{{ asset('/webrtcreact/static/js/main.chunk.js') }}"></script>
<script src="{{ asset('/webrtcreact/static/js/runtime-main.js') }}"></script>
@else
<script src="{{ asset('/js/react/2.chunk.js') }}"></script>
<script src="{{ asset('/js/react/main.chunk.js') }}"></script>

<script src="{{ asset('/js/react/runtime-main.js') }}"></script>
@endif

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-3">
            <div id="react-user-profile"></div>
        </div>
        <div class="col-md-3">
            <div id="react-user-profile2"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">


                    <div>
                        
                        入室中：
                        @if($chatUserOwn->chatJoin)
                        {{$chatUserOwn->chatJoin->chatRoom->room_name}}
                        <a href="{{ route('chatroom.join', $chatUserOwn->chatJoin->chat_room_id) }}"
                            class="btn btn-primary btn-sm">入室</a>

                        @endif
                        <br><br>
                        @if($chatUserOwn->openRoom())
                        MyRoom：{{ $chatUserOwn->openRoom()->room_name }}:

                        <a href=" {{ route('chatroom.join', $chatUserOwn->openRoom()->id) }}"
                            class="btn btn-primary btn-sm">入室</a>
                        <hr>
                        @else
                        <br>
                        My Roomを作成しますか？:
                        <a href=" {{ route('chatroom.create') }}" class="btn btn-primary btn-sm">作成</a>
                        <hr>

                        @endif
                        ALL CHATROOM
                        <ul>
                            @foreach($chatRooms as $room)

                            @if(!$room->room_name)

                            @else
                            <li>
                                {{ $room->room_name }}:
                                <a href=" {{ route('chatroom.join', $room->id) }}"
                                    class="btn btn-primary btn-sm">>入室</a>
                                <br>
                            </li>

                            @endif
                        </ul>
                        @endforeach
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const user_info = {
                name:"{{ auth()->user()->name }}",
                icon:"https://placehold.jp/3d4070/ffffff/150x150.png?text={{ auth()->user()->name }}",
                url:"{{ route('user.show', auth()->user()->id )}}"
            }
            renderProfileApp("react-user-profile", user_info);
            renderProfileApp2("react-user-profile2",　"{{ route('user.show', auth()->user()->id )}}");
        </script>
        @endsection