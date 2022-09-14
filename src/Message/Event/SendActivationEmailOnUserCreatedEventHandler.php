<?php

declare(strict_types=1);

namespace App\Message\Event;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class SendActivationEmailOnUserCreatedEventHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly MailerInterface            $mailer,
        private readonly VerifyEmailHelperInterface $verifyEmailHelper
    ) {}

    public function __invoke(UserCreatedEvent $userCreatedEvent)
    {
        $user = $userCreatedEvent->getUser();

        $signature = $this->verifyEmailHelper->generateSignature(
            'verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email = (new TemplatedEmail())
            ->from('cryptomarket@cryptomarket.com')
            ->to($user->getEmail())
            ->subject('Confirm your email at CryptoMarket')
            ->htmlTemplate('mailer/email_confirmation.html.twig')
            ->context([
                'signedUrl' => $signature->getSignedUrl()
            ]);

        $this->mailer->send($email);
    }
}