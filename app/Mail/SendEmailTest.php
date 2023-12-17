<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailTest extends Mailable
{
    use Queueable, SerializesModels;
    public $emailTemplate;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailTemplate,$subject)
    {
        $this->emailTemplate = $emailTemplate;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.marketing.email.template')
        ->subject($this->subject)
         ->with([
               'emailTemplate' => $this->emailTemplate,
           ]);
    }
}
