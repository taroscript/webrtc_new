@extends('layouts.app')

@section('content')

@if(App::environment(['local']))
  <script src="{{ asset('/webrtcreact/static/js/2.chunk.js') }}"></script>
  <script src="{{ asset('/webrtcreact/static/js/main.chunk.js') }}"></script>
  <script src="{{ asset('/webrtcreact/static/js/runtime-main.js') }}"></script>
  @else
  <script src="{{ asset('/js/profile/2.chunk.js') }}"></script>
  <script src="{{ asset('/js/profile/main.chunk.js') }}"></script>
  <script src="{{ asset('/js/profile/runtime-main.js') }}"></script>
@endif

<div id="chat"></div>

<script>

    
    window.CHAT_ENDPOINTS = {
    update : "{{ route('api.chatroom.updateTexts') }}",
    load : "{{ route('api.chatroom.getTexts') }}"
  }
  window.renderChat("chat",window.CHAT_ENDPOINTS);
  
</script>

@endsection
