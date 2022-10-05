<?php

namespace App\Decorator;

use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface UserMailerInterface extends MailerInterface
{
    public function sendActivationEmail(string $userEmail, string $signedUrl, string $template): void;

    public function sendResetPasswordToken(string $userEmail, ResetPasswordToken $resetToken, string $template): void;
}
