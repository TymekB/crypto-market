<?php

declare(strict_types=1);

namespace App\Decorator;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class EmailVerificationMailer implements EmailVerificationMailerInterface
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {}

    public function send(
        string $userEmail,
        string $signedUrl,
        string $template = 'mailer/email_confirmation.html.twig'
    ): void
    {
        $email = (new TemplatedEmail())
            ->from('cryptomarket@cryptomarket.com')
            ->to($userEmail)
            ->subject('Confirm your email at CryptoMarket')
            ->htmlTemplate($template)
            ->context([
                'signedUrl' => $signedUrl
            ]);

        $this->mailer->send($email);
    }
}