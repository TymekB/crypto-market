<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

final class UserNotValidException extends \Exception
{
    public function __construct(
        private readonly ?ConstraintViolationListInterface $violationList = null,
        string $message = "User is not valid",
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getViolationList(): ?ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}