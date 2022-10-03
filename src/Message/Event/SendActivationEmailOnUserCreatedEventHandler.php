<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Decorator\EmailVerificationMailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

#[AsMessageHandler]
final class SendActivationEmailOnUserCreatedEventHandler
{
    public function __construct(
        private readonly EmailVerificationMailerInterface $mailer,
        private readonly VerifyEmailHelperInterface       $verifyEmailHelper
    ) {}

    public function __invoke(UserCreatedEvent $userCreatedEvent)
    {
        $userId = $userCreatedEvent->getId();
        $userEmail = $userCreatedEvent->getEmail();

        $signedUrl = $this->verifyEmailHelper->generateSignature(
            'verify_email',
            $userId,
            $userEmail,
            ['id' => $userId]
        )->getSignedUrl();

        $this->mailer->send($userEmail, $signedUrl);
    }
}