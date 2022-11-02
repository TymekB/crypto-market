<?php

declare(strict_types=1);

namespace App\API;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Binance implements BinanceInterface
{
    private readonly string $url;

    public function __construct(private readonly HttpClientInterface $client)
    {
        $this->url = 'https://api.binance.com/api/v3';
    }

    public function getPrices(array $symbols = null)
    {
        $url = $this->url . '/ticker/24hr';

        if($symbols) {
            $url .= '?symbols=' . json_encode($symbols);
        }

        $response = $this->client->request('GET', $url)->getContent();

        return json_decode($response);
    }
}