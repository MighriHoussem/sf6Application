<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailerInterface)
    {
    }

    public function sendMail(): void
    {
        $email = (new Email())
                    ->to('you@example.com')
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailerInterface->send($email);
    }
}
