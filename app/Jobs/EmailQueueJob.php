<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\SendEmailTest;
class EmailQueueJob implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     public $emailTemplate;
     public $list;
     public $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailTemplate, $list, $subject)
    {
        $this->emailTemplate = $emailTemplate;
        $this->list = $list;
        $this->subject = $subject;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = $this->emailTemplate;
        $list = $this->list;

        $subject = $this->subject;
        Mail::to($list)->queue(new SendEmailTest($emailTemplate,$subject));
    }
}
