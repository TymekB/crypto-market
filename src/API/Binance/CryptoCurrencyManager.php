<?php

declare(strict_types=1);

namespace App\API\Binance;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CryptoCurrencyManager implements CryptoCurrencyManagerInterface
{
    private readonly string $url;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SerializerInterface $serializer
    )
    {
        $this->url = 'https://api.binance.com/api/v3';
    }

    public function getCryptoCurrencyBySymbol(string $symbol): CryptoCurrency
    {
        $url = sprintf('%s/ticker/24hr?symbol=%s', $this->url, $symbol);
        $jsonData = $this->client->request('GET', $url)->getContent();

        return $this->serializer->deserialize($jsonData, CryptoCurrency::class, 'json');
    }

    /**
     * @return array|Currency[]
    */
    public function getCryptoCurrenciesBySymbol(array $symbols = null): array
    {
        $url = $this->url . '/ticker/24hr';

        if($symbols) {
            $url .= '?symbols=' . json_encode($symbols);
        }

        $jsonData = $this->client->request('GET', $url)->getContent();

        return $this->serializer->deserialize($jsonData, CryptoCurrency::class . '[]', 'json');
    }
}