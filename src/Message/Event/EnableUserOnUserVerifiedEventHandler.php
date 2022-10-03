<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EnableUserOnUserVerifiedEventHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(UserVerifiedEvent $userVerifiedEvent): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        $userId = $userVerifiedEvent->getId();

        $user = $userRepository->find($userId);
        $user->setVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}