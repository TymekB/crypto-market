<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\Form\Type\CryptoCurrencyTransactionQuantityFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class BuyCryptoCurrencyAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly FormFactoryInterface $formFactory
    )
    {
    }

    public function __invoke(string $symbol)
    {
        return new Response(
            $this->twig->render('cryptocurrency/buy.html.twig', [
                'symbol' => $symbol
            ])
        );
    }
}