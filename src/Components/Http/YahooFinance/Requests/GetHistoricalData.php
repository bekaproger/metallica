<?php

namespace App\Components\Http\YahooFinance\Requests;

use App\Components\Http\YahooFinance\Exceptions\YahooFinanceException;
use App\Components\Http\YahooFinance\Response\HistoricalData\HistoricalData;
use App\Components\Http\YahooFinance\Response\HistoricalData\Price;
use App\Components\Http\YahooFinance\Response\HistoricalData\Timezone;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

final class GetHistoricalData
{
    public const URI = 'get-historical-data';

    public function execute(ClientInterface $client, string $symbol, string $region = null): HistoricalData
    {
        $query = [
            'symbol' => $symbol,
        ];

        if (!empty($region)) {
            $query['region'] = $region;
        }

        try {
            $uri = self::URI.'?'.http_build_query($query);
            $request = new Request('GET', $uri);
            $data = $client->sendRequest($request);

            $array = json_decode($data->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return $this->mapResponse($array);
        } catch (\Throwable $exception) {
            throw new YahooFinanceException(sprintf('Error on %s: %s', self::class, $exception->getMessage()), $exception->getCode());
        }
    }

    private function mapResponse(array $data): HistoricalData
    {
        $prices = [];
        foreach ($data['prices'] as $price) {
            if (key_exists('date', $price)
                && key_exists('open', $price)
                && key_exists('high', $price)
                && key_exists('low', $price)
                && key_exists('close', $price)
                && key_exists('volume', $price)
            ) {
                $prices[] = $this->mapPrice($price);
            }
        }

        return new HistoricalData(
            prices: $prices,
            isPending: $data['isPending'] ?? null,
            firstTradeDate: $data['firstTradeDate'] ?? null,
            id: $data['id'] ?? null,
            timezone: empty($data['timezone'] ?? null) ? null : new Timezone(gmtOffset: $data['timezone']['gmtOffset']),
            eventData: $data['eventData'] ?? null
        );
    }

    private function mapPrice(array $priceData): Price
    {
        return new Price(
            date: $priceData['date'],
            open: $priceData['open'],
            high: $priceData['high'],
            low: $priceData['low'],
            close: $priceData['close'],
            volume: $priceData['volume'],
            adjClose: $priceData['adjclose'] ?? null
        );
    }
}
