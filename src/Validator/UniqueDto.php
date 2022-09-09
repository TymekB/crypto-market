<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

final class UniqueDto extends Constraint
{
    public ?string $atPath = null;
    public string $entityClass;
    public string|array $fields;
    public string $message = 'This value is already used.';

    public function getTargets(): string
    {
        return parent::CLASS_CONSTRAINT;
    }
}