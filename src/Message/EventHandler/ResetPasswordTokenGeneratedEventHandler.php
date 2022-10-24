<?php

declare(strict_types=1);

namespace App\Message\EventHandler;

use App\Decorator\UserMailer;
use App\Message\Event\ResetPasswordTokenGeneratedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ResetPasswordTokenGeneratedEventHandler
{
    public function __construct(private readonly UserMailer $userMailer)
    {
    }

    public function __invoke(ResetPasswordTokenGeneratedEvent $resetPasswordTokenGeneratedEvent)
    {
        $userEmail = $resetPasswordTokenGeneratedEvent->getUserEmail();
        $resetToken = $resetPasswordTokenGeneratedEvent->getResetToken();

        $this->userMailer->sendResetPasswordToken($userEmail, $resetToken);
    }

}