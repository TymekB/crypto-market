<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Decorator\UserCryptoCurrencyManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class ShowDashboardAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly UserCryptoCurrencyManagerInterface $userCryptoCurrencyManager
    ) {}

    public function __invoke(UserInterface $user): Response
    {
        /** @var User $user */
        $cryptoCurrencyList = $this->userCryptoCurrencyManager->getUserCryptoCurrencyList($user);

        /** @var User $user */
        return new Response($this->twig->render('dashboard.html.twig',
            [
                'cryptoCurrencyList' => $cryptoCurrencyList,
                'user' => $user
            ]
        ));
    }
}