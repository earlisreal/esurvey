<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail extends Job implements ShouldQueue
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
        try {
            Mail::send('emails.activation',
                [
                    'code' => $this->user->activation_code,
                    'id' => $this->user->id,
                    'name' => $this->user->first_name . ' ' . $this->user->last_name
                ], function ($message) {
                    $message->subject('eSurvey Verification');
                    $message->to($this->user->email);
                });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
