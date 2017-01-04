<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Survey;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Storage;
use Log;

class SaveQuestionSpeech extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $survey;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->survey->pages as $page) {
            foreach ($page->questions as $question) {
                $client = new Client();
                Log::info($question->question_title);
                $res = $client->get('https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize',
                    [
                        'auth' => [config('app.tts_username'), config('app.tts_password')],
                        'headers' => ['Accept' => 'audio/wav'],
                        'query' => [
                            'text' => $question->question_title
                        ]
                    ]);
                Log::info("TTS RESPONSE -> " . $res->getStatusCode());
//                echo $res->getStatusCode() . "\n";
                if ($res->getStatusCode() == 200) {
                    Storage::disk('sound')->put('speech/question' . $question->id . '.wav', $res->getBody());
                }
            }
        }
    }
}
