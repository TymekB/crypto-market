<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\API\Binance\CryptoCurrencyManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class BuyCryptoCurrencyAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager
    )
    {
    }

    public function __invoke(string $symbol): Response
    {
        $cryptoCurrencyPrice = $this->cryptoCurrencyManager->getCryptoCurrencyBySymbol($symbol)->getLastPrice();

        return new Response(
            $this->twig->render('cryptocurrency/buy.html.twig', [
                'symbol' => $symbol,
                'price' => $cryptoCurrencyPrice
            ])
        );
    }
}