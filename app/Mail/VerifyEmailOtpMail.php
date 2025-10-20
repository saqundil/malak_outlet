<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;

    public function __construct($otp, $userName = null)
    {
        $this->otp = $otp;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('كود التحقق من البريد الإلكتروني - Malak Outlet')
            ->view('emails.verify-otp')
            ->with([
                'otp' => $this->otp,
                'userName' => $this->userName
            ]);
    }
}
