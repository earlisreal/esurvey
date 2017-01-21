<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\ResponseDetail;
use GuzzleHttp\Client;
use Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnalyzeText extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $detail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ResponseDetail $detail)
    {
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

//        Log::info("Sentiment Analysis");
        $res = $client->get('https://gateway-a.watsonplatform.net/calls/text/TextGetTextSentiment',
            [
                'query' => [
                    'apikey' => config('app.alchemy_key'),
                    'text' => $this->detail->text_answer,
                    'outputMode' => 'json'
                ]
            ]);
//                                    Log::info($res->getBody());
        $analysis = json_decode($res->getBody());
//        Log::info("Status -> " . $analysis->status);
        if($res->getStatusCode() == 200){
            $this->detail->update([
                'sentiment' => $analysis->docSentiment->type
            ]);
        }
    }
}
