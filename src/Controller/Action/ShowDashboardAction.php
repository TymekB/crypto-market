<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\API\Binance\CryptoCurrencyManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ShowDashboardAction
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

        return new Response($this->twig->render('dashboard.html.twig',
            [
                'cryptoCurrencyList' => $cryptoCurrencyList
            ]
        ));
    }
}