<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class TransactionHistoryAction
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function __invoke(UserInterface $user): Response
    {
        /** @var User $user */

        return new Response(
            $this->twig->render('cryptocurrency/history.html.twig',
                [
                    'transactionHistory' => $user->getTransactionSummaries(),
                    'userBalance' => $user->getBalance()
                ]
            )
        );
    }
}