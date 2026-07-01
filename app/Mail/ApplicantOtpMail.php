<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $jobTitle;

    public function __construct($otp, $jobTitle)
    {
        $this->otp = $otp;
        $this->jobTitle = $jobTitle;
    }

    public function build()
    {
        return $this->from(env('REC_MAIL_FROM_ADDRESS'), env('REC_MAIL_FROM_NAME'))
                    ->subject('Your OTP Verification Code - BIIE Careers')
                    ->view('Emails.applicant_otp');
    }
}