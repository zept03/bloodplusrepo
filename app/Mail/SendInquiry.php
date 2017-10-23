<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Inquiry;

class SendInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $send = $this->inquiry;
        return $this->view('emails.inquiry',compact('send'));
    }
}
