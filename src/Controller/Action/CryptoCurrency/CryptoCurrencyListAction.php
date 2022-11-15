<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class CryptoCurrencyListAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly CryptoCurrencyManagerInterface $binanceAPI
    ) {}

    public function __invoke(): Response
    {
        $cryptoCurrencyList = $this->binanceAPI->getCryptoCurrenciesBySymbol([
            'BTCUSDT',
            'ETHUSDT',
            'LTCUSDT'
        ]);

        return new Response($this->twig->render('cryptocurrency/list.html.twig',
            [
                'cryptoCurrencyList' => $cryptoCurrencyList
            ]
        ));
    }
}