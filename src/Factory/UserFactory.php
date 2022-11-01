<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function createUser(string $email, string $plainPassword): User
    {
        $user = new User();

        $password = $this->userPasswordHasher->hashPassword($user, $plainPassword);

        $user->setEmail($email);
        $user->setPassword($password);

        $errors = $this->validator->validate($user);

        if(count($errors) > 0) {
            throw new \Exception((string)$errors);
        }

        return $user;
    }
}