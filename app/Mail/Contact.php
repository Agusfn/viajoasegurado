<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;


    public $name_from;
    public $mail_from;
    public $contact_reason;
    public $contract_no;
    public $message;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name_from, $mail_from, $contact_reason, $contract_no, $message)
    {
        $this->name_from = $name_from;
        $this->mail_from = $mail_from;
        $this->contact_reason = $contact_reason;
        $this->contract_no = $contract_no;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->view('mails.contact')
        ->replyTo($this->mail_from, $this->name_from)
        ->from(config("mail.from.address"), $this->name_from);
    }
}
