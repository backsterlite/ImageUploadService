<?php


namespace App\models;


class Mail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {

        $this->mailer = $mailer;
    }
    public function send($mail, $body)
    {
        $message = (new \Swift_Message('Добро пожаловать'))
                    ->setfrom('coilofluck@gmail.com','Our Portal')
                    ->setTo($mail)
                    ->setBody($body);
        return $this->mailer->send($message);

    }
}