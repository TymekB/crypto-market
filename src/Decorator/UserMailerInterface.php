<?php

namespace App\Decorator;

use Symfony\Component\Mailer\MailerInterface;

interface UserMailerInterface extends MailerInterface
{
    public function sendActivationEmail(string $userEmail, string $signedUrl, string $template): void;

    public function sendResetPasswordToken(string $userEmail, string $resetToken, string $template): void;
}
