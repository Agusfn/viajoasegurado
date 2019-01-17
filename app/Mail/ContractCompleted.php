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
        {
            $this->subject("Your travel insurance has been successfully processed and the voucher has been sent");
            return $this->view('mails.contracts.completed_en')->text("mails.contracts.completed_en_plain")->with("fullname", $fullname);
        }
        else if(\App::isLocale("es"))
        {
            $this->subject("Tu seguro de viaje fue procesado exitosamente y el voucher ha sido enviado");
            return $this->view('mails.contracts.completed_es')->text("mails.contracts.completed_es_plain")->with("fullname", $fullname);
        }
    }
}
