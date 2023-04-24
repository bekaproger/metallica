<?php

namespace App\Components\Http\YahooFinance;

use App\Components\Http\YahooFinance\Requests\GetHistoricalData;
use App\Components\Http\YahooFinance\Response\HistoricalData\HistoricalData;
use Psr\Http\Client\ClientInterface;

class YahooFinanceClient
{
    public function __construct(
        private readonly ClientInterface $client
    ) {
    }

    public function getHistoricalData(string $symbol, string $region = null): HistoricalData
    {
        return (new GetHistoricalData())->execute($this->client, $symbol, $region);
    }
}
