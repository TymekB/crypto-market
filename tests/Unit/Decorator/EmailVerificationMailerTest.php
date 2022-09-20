<?php

namespace App\Tests\Unit\Decorator;

use App\Decorator\EmailVerificationMailer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;

class EmailVerificationMailerTest extends TestCase
{
    public function testIfVerificationEmailIsBeingSent(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer
            ->expects($this->once())
            ->method('send');

        $emailVerificationMailer = new EmailVerificationMailer($mailer);
        $emailVerificationMailer->send(
            'test@example.com',
            ''
        );
    }
}
