<?php

declare(strict_types=1);

namespace App\Entity;

use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

    private ?int $id = null;
    private ?User $user;

    public function __construct(
        object             $user,
        \DateTimeInterface $expiresAt,
        string             $selector,
        string             $hashedToken
    )
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): object
    {
        return $this->user;
    }
}