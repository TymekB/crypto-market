<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Security\Exception\UserNotVerifiedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getVerified()) {
            throw new UserNotVerifiedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}