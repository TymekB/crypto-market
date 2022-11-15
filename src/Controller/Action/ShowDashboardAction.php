<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Entity\User;
use App\Factory\WalletFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class ShowDashboardAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly WalletFactoryInterface $walletFactory
    ) {}

    public function __invoke(UserInterface $user): Response
    {
        /** @var User $user */
        $wallet = $this->walletFactory->create($user);

        /** @var User $user */
        return new Response($this->twig->render('dashboard.html.twig',
            [
                'wallet' => $wallet,
            ]
        ));
    }
}