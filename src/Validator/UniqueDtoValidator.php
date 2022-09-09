<?php

declare(strict_types=1);

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class UniqueDtoValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface    $entityManager,
        private readonly PropertyAccessorInterface $propertyAccessor
    ){}

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueDTO) {
            throw new UnexpectedTypeException($constraint, UniqueDTO::class);
        }

        if (!$constraint->entityClass) {
            throw new InvalidArgumentException('Entity class is required.');
        }

        $repository = $this->entityManager->getRepository($constraint->entityClass);

        $fields = (array) $constraint->fields;
        $criteria = [];

        foreach ($fields as $field) {
            $criteria[$field] = $this->propertyAccessor->getValue($value, $field);
        }

        if (!$repository->count($criteria)) {
            return;
        }

        $violation = $this->context->buildViolation($constraint->message);

        if ($constraint->atPath) {
            $violation->atPath($constraint->atPath);
        }

        $violation->addViolation();
    }
}