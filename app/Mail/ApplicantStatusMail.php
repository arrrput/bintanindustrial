<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Applicant;

class ApplicantStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;

    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }

    public function build()
    {
        return $this->from(env('REC_MAIL_FROM_ADDRESS'), env('REC_MAIL_FROM_NAME'))
                    ->subject('Application Status Update - BIIE Careers')
                    ->view('Emails.applicant_status');
    }
}