<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

final class LoginUserAction
{
    public function __construct(
        private readonly Environment                   $twig,
        private readonly AuthenticationUtils           $authenticationUtils,
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly RouterInterface               $router
    ) {}

    public function __invoke(Request $request): Response
    {
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->router->generate('dashboard'));
        }

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