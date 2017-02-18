<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Log;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("sending mail");
        $activationCode = str_random(50);
        $this->user->update([
            'activation_code' => $activationCode
        ]);
        Mail::send('emails.activation',
            [
                'code' => $this->user->activation_code,
                'id' => $this->user->id,
                'name' => $this->user->first_name . ' ' . $this->user->last_name
            ], function ($message) {
                $message->subject('eSurvey Verification');
                $message->to($this->user->email);
            });
        Log::info("Mail Sent");
    }
}
