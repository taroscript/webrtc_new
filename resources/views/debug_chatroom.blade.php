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

<div id="chat"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                
                  <div>
                    <div>部屋名:{{ $room->room_name }}

                    <div>@if($isHost) host @else guest @endif</div>
                    
                    <div>member</div>
                    <ul>
                    
                    @foreach($members as $member)
                        <li>{{$member->chatUser->nickname}}  @if($member->isHost()) * @endif</li>
                    @endforeach
                    </ul>
                      <hr>
                      <div>
                        <input type="checkbox" id="checkbox_camera" onclick="mywebrtc.onclickCheckbox_CameraMicrophone()">Camera
                        <input type="checkbox" id="checkbox_microphone" onclick="mywebrtc.onclickCheckbox_CameraMicrophone()">Microphone
                        
                        

                      </div>
                      <div>
                        <video id="video_local" width="320" height="240" style="border:1px solid blak;" autoplay><video>
                        <audio id="audio_local" autoplay></audio>
                    </div>
                      <div>
                        <video id="video_remote" width="320" height="240" style="border: 1px solid black;" autoplay></video>
                        <audio id="audio_remote" autoplay></audio>
                      </div>
                    <div>messages</div>
                    <ul>
                    @foreach($messages as $message)
                        <li>{{ $message->message }} by {{ $message->chatUser->nickname }}</li>
                    @endforeach
                    </ul>

                    <form method="post" action="{{ route('chatroom.message') }}">
                        @csrf
                        <p>message:<input type="text" name="message"></p>
                        <p><input type="submit" value="send"></p>
                        <p><input type="button" value="send(ajax)" id="btn-send-ajax"></p>
                    </form>
                    <p><input type="button" value="video-start" id="btn-video-start"></p>
                    <p><input type="button" value="video-end" id="btn-video-end"></p>
                    <a href="{{ route('chatroom.leave')}}" class="btn btn-primary">退室</a>
                    <hr>
                    <div class="form-group">
                        <h4>video</h4>
                        <textarea id="sdp_input" type="text" name="message" class="form-control">uid:{{$chatUser->id}}</textarea>
                        <br>
                        <input type="button" value="Send SDP(Ajax)" class="btn btn-primary" id="btn-send-sdp"/>

                    </div>
                    <div class="form-group">
                        <h4>video info</h4>
                        <textarea id="video_info" type="text" name="message" class="form-control"></textarea>
                        <br>
                        
                  </div>
                  <hr>
                  <div>debug offer SDP</div>
                  <textarea id="textarea_offerside_offersdp" row="10" cols="40" readonly="readonly"></textarea>
                  <div>debug answer SDP</div>
                  <textarea id="textarea_answerside_answersdp" row="10" cols="40" readonly="readonly"></textarea>
                  <div>debug botton</div>
                  <input type="bottun" id="set_answer_sdp" value="set answer sdp" class="btn btn-primary">
                  <input type="bottun" id="test" value="test" class="btn btn-primary">
                </div>
             </div>
          </div>
      </div>
</div>
<script src="{{ asset('webrtcphp/dist/client.js') }}"></script>
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

        $("#btn-send-ajax").on("click", function(){
            $.post("{{ route('api.chatroom.message') }}", {
                
            }, function(res){
                alert("ok",res)
                console.log("res")
            });
            
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

        $("#btn-send-sdp").on("click",function(){
            $.post("{{ route('api.chatroom.update_sdp') }}",{
                sdp : $("#sdp_input").val()
            }, function(res){
                alert("ok", res)
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
        
        setInterval(() => {
            $.get("{{ route('api.chatroom.videoInfo') }}", {
            }, function(res){
                $("#video_info").val(JSON.stringify(res));
            });
            
        }, 5000);

        $("#set_answer_sdp").on("click", function(){
            console.log("setAnswerSDPthenChatStarts()")
            mywebrtc.setAnswerSDPthenChatStarts();
        })
    })
    
</script>
@endsection
        