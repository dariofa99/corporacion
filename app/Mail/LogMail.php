<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CaseLog;
class LogMail extends Mailable
{
    use Queueable, SerializesModels;
    public $caseL;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CaseLog $caseL,$token)
    {
        $this->caseL = $caseL;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->caseL->concept)
        ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
        ->view('mail.log_defendant_notification')
        ->with([ 'token' => $this->token,'caseL' => $this->caseL]);
    }
}
