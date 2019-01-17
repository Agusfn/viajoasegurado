<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Contract;

class ContractCompleted extends Mailable
{
    use Queueable, SerializesModels;


    public $contract;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $passg_details = $this->contract->getPassengerDetails();
        $fullname = $passg_details[0]["name"]." ".$passg_details[0]["surname"];

        if(\App::isLocale("en"))
            return $this->view('mails.contracts.completed_en')->with("fullname", $fullname);
        else if(\App::isLocale("es"))
            return $this->view('mails.contracts.completed_es')->with("fullname", $fullname);
    }
}
