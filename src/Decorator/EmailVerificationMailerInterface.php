<?php

namespace App\Decorator;

interface EmailVerificationMailerInterface
{
    public function send(string $userEmail, string $signedUrl, string $template);
}