<?php
declare(strict_types=1);

namespace App\Tests\TestServices;

use App\Components\Http\YahooFinance\Response\HistoricalData\HistoricalData;
use App\Components\Http\YahooFinance\Response\HistoricalData\Price;

use DateTime;

class TestYahooFinanceService
{
    public function createHistoricalPricesResponse(DateTime $startDate, int $pricesCount = 10): HistoricalData
    {
        return new HistoricalData(
            prices: $this->createPrices($startDate, $pricesCount),
        );
    }

    public function createPrices(DateTime $startDate, int $count = 2): array
    {
        $prices = [];
        $i = 0;
        while ($i < $count) {
            $prices[] = new Price(
                (clone $startDate)->add(new \DateInterval("P{$i}D"))->getTimestamp(),
                mt_rand(0, 100),
                mt_rand(50, 150),
                mt_rand(0, 70),
                mt_rand(0, 100),
                mt_rand(0, 100),
                null,
            );

            $i++;
        }

        return $prices;
    }
}