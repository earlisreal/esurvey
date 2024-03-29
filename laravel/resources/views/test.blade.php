@extends('layouts.app')

@section('content')
    <!-- CSS Styles -->
    <style>
        .speech {border: 1px solid #DDD; width: 300px; padding: 0; margin: 0}
        .speech input {border: 0; width: 240px; display: inline-block; height: 30px;}
        .speech img {float: right; width: 40px }
    </style>

    <!-- Search Form -->
    <form id="labnol" method="get" action="https://www.google.com/search">
        <div class="speech">
            <input type="text" name="q" id="transcript" placeholder="Speak" />
            <img onclick="textToSpeech()" src="//i.imgur.com/cHidSVu.gif" />
        </div>
    </form>

    <!-- HTML5 Speech Recognition API -->
    <script>
        function startDictation() {
            if (window.hasOwnProperty('webkitSpeechRecognition')) {

                var recognition = new webkitSpeechRecognition();

                recognition.continuous = false;
                recognition.interimResults = false;

                recognition.lang = "en-US";
                recognition.start();

                recognition.onresult = function(e) {
                    console.log("voice found");
                    console.log(e.results[0][0].transcript);
                    document.getElementById('transcript').value
                        = e.results[0][0].transcript;
                    recognition.stop();
//                    document.getElementById('labnol').submit();
                };

                recognition.onerror = function(e) {
                    recognition.stop();
                }

            }
        }

        function textToSpeech(){
            var msg = new SpeechSynthesisUtterance('Hello World');
            window.speechSynthesis.speak(msg);
        }
    </script>
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection