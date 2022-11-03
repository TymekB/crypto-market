<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\API\BinanceInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ShowDashboardAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly BinanceInterface $binanceAPI
    ) {}


    public function __invoke(): Response
    {
        $cryptoCurrencyList = $this->binanceAPI->getPrices([
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