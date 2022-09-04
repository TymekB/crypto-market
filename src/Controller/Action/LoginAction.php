<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

final class LoginAction
{
    public function __construct(private Environment $twig, private AuthenticationUtils $authenticationUtils)
    {
    }

    public function __invoke(): Response
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $error = $this->authenticationUtils->getLastAuthenticationError();

        return new Response(
            $this->twig->render('login.html.twig',
                [
                    'last_username' => $lastUsername,
                    'error' => $error
                ]
            ),
        );
    }
}