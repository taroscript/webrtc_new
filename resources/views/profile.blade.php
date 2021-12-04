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

<div id="createprofile"></div>

<script>

    
    window.PROFILE_ENDPOINTS = {
    update : "{{ route('user.update', auth()->user()->id) }}",
    load : "{{ route('user.show', auth()->user()->id) }}"
  }
  window.renderUpdateProfile("createprofile",window.PROFILE_ENDPOINTS);
  
</script>

@endsection
