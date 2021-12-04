@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    
                <div>hello</div>
                        
                <input type="button" id="btn-ajax" value="ajax" class="btn btn-primary"/>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('webrtcphp/dist/client.js') }}"></script>
<script>
  mywebrtc.setEndpoint({
    "getVideo" : "{{ route('test.api') }}"
  });

  $("#btn-ajax").on("click",function(){
    alert(1);
    mywebrtc.abc();
  });
</script>
@endsection
