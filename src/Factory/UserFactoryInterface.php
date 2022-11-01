<?php

namespace App\Factory;

use App\Entity\User;

interface UserFactoryInterface
{
    public function createUser(string $email, string $plainPassword): User;
}