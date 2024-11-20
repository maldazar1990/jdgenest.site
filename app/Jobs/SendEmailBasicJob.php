<?php

namespace App\Jobs;

use App\Mail\SendEmailBasic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as Mail;

class SendEmailBasicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private string $to, $title, $message, $mailView;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to,$title,$view,$message="")
    {
        
        $this->to = $to;
        $this->title = $title;
        $this->message = $message;
        $this->mailView = $view;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("email start");

        $email = new SendEmailBasic($this->title,$this->mailView,$this->message);
        Mail::to($this->to)
            ->send($email);

        Log::info("email end");
    }
}
