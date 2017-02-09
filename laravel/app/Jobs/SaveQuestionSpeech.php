<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Question;
use App\Survey;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Storage;
use Log;
use RobbieP\CloudConvertLaravel\Facades\CloudConvert;

class SaveQuestionSpeech extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $question;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        Log::info($this->question->question_title);
        $res = $client->get('https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize',
            [
                'auth' => [config('app.tts_username'), config('app.tts_password')],
                'headers' => ['Accept' => 'audio/wav'],
                'query' => [
                    'text' => $this->question->question_title
                ]
            ]);
        Log::info("TTS RESPONSE -> " . $res->getStatusCode());
//                echo $res->getStatusCode() . "\n";
        if ($res->getStatusCode() == 200) {
            $wav = $res->getBody();
            Storage::disk('sound')->put('speech/wav/question' . $this->question->id . '.wav', $wav);

//            CloudConvert::file(base_path('../public/sounds/speech/wav/question' .$this->question->id .'wav'))->to(base_path('../public/sounds/speech/mp3/question' .$this->question->id .'mp3'));

            $descriptorspec = array(
                0 => array("pipe", "r"),
                1 => array("pipe", "w"),
                2 => array("file", base_path("../public/sounds/speech/wav/null"), "w")
            );

            Log::info("Opening Process..");

            $process = proc_open(base_path('../public/plugins/lame/lame.exe - -'), $descriptorspec, $pipes);

            Log::info("Process Opened");

            fwrite($pipes[0],  Storage::disk('sound')->get('speech/wav/question' . $this->question->id . '.wav', $wav));

            Log::info("FWRITE SUCCEED!");

            fclose($pipes[0]);

            Log::info("Writing to WAV variable");

            $mp3 = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            Log::info("CLOSING PROCESS...");

            proc_close($process);

            Log::info("Saving into mp3...");

            Storage::disk('sound')->put('speech/mp3/question' . $this->question->id . '.mp3', $mp3);

            Log::info("Mp3 SAVED!");
        }
    }
}
