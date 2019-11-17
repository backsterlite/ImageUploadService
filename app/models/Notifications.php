<?php


namespace App\models;




class Notifications
{
    private $mailer;

    public function __construct(Mail $mailer)
    {

        $this->mailer = $mailer;
    }

        public function emailWasChange($email, $selector,  $token)
        {
            $message = 'https://example02/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $this->mailer->send($email, $message);
        }
}