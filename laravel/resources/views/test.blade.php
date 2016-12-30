@extends('layouts.app')

@section('content')
    <audio controls autoplay></audio>

    <button id="start">Start</button>
    <button id="stop">Stop</button>
@endsection

@section('scripts')
    <script>
        $('#start').click(function () {
           startRecording();
        });

        $('#stop').click(function () {
            stopRecording();
        });

        function hasGetUserMedia() {
            return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia || navigator.msGetUserMedia);
        }

        if (hasGetUserMedia()) {
            // Good to go!
            console.log("media enabled");
        } else {
            alert('getUserMedia() is not supported in your browser');
        }

        var errorCallback = function(e) {
            console.log('Reeeejected!', e);
        };

        navigator.getUserMedia  = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia;

        
    </script>
@endsection