<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateUserCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function __invoke(CreateUserCommand $createUserCommand)
    {
        $user = new User();

        $email = $createUserCommand->getEmail();
        $password = $this->passwordHasher->hashPassword(
            $user,
            $createUserCommand->getPassword(),
        );

        $user->setEmail($email);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}