<?php

declare(strict_types=1);

namespace App\API\Binance\CryptoCurrency\Manager;

use App\API\Binance\CryptoCurrency;
use App\Exception\CryptoCurrency\CryptoCurrencySymbolNotFoundException;
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

    public function getCryptoCurrency(string $symbol): CryptoCurrency
    {
        $url = sprintf('%s/ticker/24hr?symbol=%s', $this->url, $symbol);
        $response = $this->client->request('GET', $url);

        if($response->getStatusCode() != 200) {
            throw new CryptoCurrencySymbolNotFoundException();
        }

        $json = $response->getContent();

        return $this->serializer->deserialize($json, CryptoCurrency::class, 'json');
    }

    /**
     * @return array|Currency[]
    */
    public function getCryptoCurrencies(array $symbols = null): array
    {
        $url = $this->url . '/ticker/24hr';

        if($symbols) {
            $url .= '?symbols=' . json_encode($symbols);
        }

        $jsonData = $this->client->request('GET', $url)->getContent();

        return $this->serializer->deserialize($jsonData, CryptoCurrency::class . '[]', 'json');
    }
}