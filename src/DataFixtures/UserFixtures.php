<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN']
        ]);

        UserFactory::createOne([
            'email' => 'user@example.com',
            'password' => 'user',
        ]);

        UserFactory::createOne([
            'email' => 'newuser@example.com',
            'password' => 'user',
            'roles' => ['ROLE_USER'],
            'verified' => false
        ]);
    }
}