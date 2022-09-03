<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class LoginAction
{
    public function __construct(private Environment $twig)
    {
    }

    public function __invoke()
    {

    }
}