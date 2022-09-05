<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class RegisterUserAction
{
    public function __construct(
        private readonly Environment $twig,
    ) {}


    public function __invoke()
    {
        return new Response($this->twig->render('register.html.twig'));
    }

}