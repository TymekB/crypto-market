<?php

declare(strict_types=1);

namespace App\API;

use App\API\Binance\CryptoCurrency;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Binance implements BinanceInterface
{
    private readonly string $url;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SerializerInterface $serializer
    )
    {
        $this->url = 'https://api.binance.com/api/v3';
    }

    /**
     * @return array|Currency[]
    */
    public function getPrices(array $symbols = null): array
    {
        $url = $this->url . '/ticker/24hr';

        if($symbols) {
            $url .= '?symbols=' . json_encode($symbols);
        }

        $jsonData = $this->client->request('GET', $url)->getContent();

        return $this->serializer->deserialize($jsonData, CryptoCurrency::class . '[]', 'json');
    }
}