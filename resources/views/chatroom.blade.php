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
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">部屋名:{{ $room->room_name }}</div>

                <div class="card-body">

                    <div>
                        <div>
                            <ul>
                                @foreach($members as $member)
                                <li>{{$member->chatUser->nickname}} @if($member->isHost()) * @endif</li>
                                @endforeach
                            </ul>
                            <hr>
                            <div>



                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-xl-3">
                                    <video id="video_local" width="320" height="240" style="border:1px solid black;"
                                        autoplay><video>
                                            <audio id="audio_local" autoplay></audio>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <video id="video_remote" width="320" height="240" style="border: 1px solid black;"
                                        autoplay></video>
                                    <audio id="audio_remote" autoplay></audio>
                                </div>
                            </div>
                            <div class="row justify-content-center p-3">
                                <div class="col-md-8">
                                    <input type="checkbox" id="checkbox_camera"
                                        onclick="mywebrtc.onclickCheckbox_CameraMicrophone()">Camera
                                    <input type="checkbox" id="checkbox_microphone"
                                        onclick="mywebrtc.onclickCheckbox_CameraMicrophone()">Microphone
                                    <input type="button" value="video-start" id="btn-video-start"
                                        class="btn btn-primary">
                                    <input type="button" value="video-end" id="btn-video-end" class="btn btn-primary">
                                </div>
                            </div>
                            <div id="chat"></div>
                            <a href="{{ route('chatroom.leave')}}" class="btn btn-primary">退室</a>
                            

                            {{-- <div class="form-group">
                                <hr>
                                <h4>video info</h4>
                                <textarea id="video_info" type="text" name="message" class="form-control"></textarea>
                                <br>

                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(App::environment(['local']))
        <script src="{{ asset('webrtcphp/dist/client.js') }}"></script>
        @else
        <script src="{{ asset('/js/webrtc/client.js') }}"></script>
        @endif

        <script>
            window.CHAT_ENDPOINTS = {
                update : "{{ route('api.chatroom.updateTexts') }}",
                load : "{{ route('api.chatroom.getTexts') }}"
            }
            window.renderChat("chat",window.CHAT_ENDPOINTS);
  
        </script>

        <script>
            $(function(){
        
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr("content")
                }
        });

        
        $("#btn-video-start").on("click",function(){
            $.post("{{ route('api.chatroom.video.start') }}", {
                message : $(this).parents("form").find("input[name=message]").val()
            }, function(res){
                console.log("video start cliked")
                mywebrtc.videoStart({{ $isHost }})
            });
        });

        $("#btn-video-end").on("click", function(){
            $.post("{{ route('api.chatroom.video.end') }}", {
                message : $(this).parents("form").find("input[name=message").val()
            }, function(res){
                alert("video end ok", res)
            });
        });

        

        $("#test").on("click",function(){
            mywebrtc.test();
        });

        mywebrtc.setEndPoint({
            update_sdp:"{{route('api.chatroom.update_sdp')}}",
            get_video_info:"{{ route('api.chatroom.videoInfo') }}"
        })

        mywebrtc.connectionType("{{ $connectionType }}");
        
        // setInterval(() => {
        //     $.get("{{ route('api.chatroom.videoInfo') }}", {
        //     }, function(res){
        //         $("#video_info").val(JSON.stringify(res));
        //     });
            
        // }, 5000);

    
    })
    
        </script>
        @endsection