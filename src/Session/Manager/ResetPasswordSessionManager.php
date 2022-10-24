<?php

declare(strict_types=1);

namespace App\Session\Manager;

use Symfony\Component\HttpFoundation\RequestStack;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

final class ResetPasswordSessionManager implements ResetPasswordSessionManagerInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getTokenFromSession(): ?string
    {
        $session = $this->requestStack->getSession();

        return $session->get('ResetPasswordPublicToken');
    }

    public function storeTokenInSession(string $token): void
    {
        $session = $this->requestStack->getSession();
        $session->set('ResetPasswordPublicToken', $token);
    }

    public function getTokenObjectFromSession(): ?ResetPasswordToken
    {
        return $this->requestStack
            ->getSession()
            ->get('ResetPasswordToken');
    }

    public function cleanSessionAfterReset(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove('ResetPasswordPublicToken');
        $session->remove('ResetPasswordCheckEmail');
        $session->remove('ResetPasswordToken');
    }
}