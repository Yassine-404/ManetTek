<?php
// src/Service/EmailService.php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $recipient, string $subject, string $content): void
    {
        $email = (new Email())
            ->from('support@vivaverse.site')
            ->to($recipient)
            ->subject($subject)
            ->text($content);

        $this->mailer->send($email);
    }
}