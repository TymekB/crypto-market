<?php

declare(strict_types=1);

namespace App\Decorator;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

#[AsDecorator(decorates: Mailer::class)]
final class UserMailer implements UserMailerInterface
{
    private readonly MailerInterface $mailer;

    public function __construct(#[MapDecorated] $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        $this->mailer->send($message, $envelope);
    }

    public function sendActivationEmail(
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

        $this->send($email);
    }

    public function sendResetPasswordToken(
        string $userEmail,
        string $resetToken,
        string $template = 'mailer/reset_password.html.twig'
    ): void
    {
        $email = (new TemplatedEmail())
            ->from('cryptomarket@cryptomarket.com')
            ->to($userEmail)
            ->subject('Password reset request')
            ->htmlTemplate($template)
            ->context([
                'resetToken' => $resetToken,
            ]);

        $this->send($email);
    }
}