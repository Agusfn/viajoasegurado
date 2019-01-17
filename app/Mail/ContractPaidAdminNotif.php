<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Contract;
use App\PaymentRequest;

class ContractPaidAdminNotif extends Mailable
{
    use Queueable, SerializesModels;


    public $contract;
    public $paymentRequest;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contract $contract, PaymentRequest $paymentRequest)
    {
        $this->contract = $contract;
        $this->paymentRequest = $paymentRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.contracts.paid_admin_notif');
    }
}
