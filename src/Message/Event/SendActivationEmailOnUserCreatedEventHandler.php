<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Decorator\EmailVerificationMailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class SendActivationEmailOnUserCreatedEventHandler implements MessageHandlerInterface
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