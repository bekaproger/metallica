<?php

namespace App\Services\FinanceService;

use App\Components\Http\YahooFinance\YahooFinanceClient;
use App\Dto\GetCompanyPricesByDatesDto;
use App\Services\FinanceService\Entity\Price;

class YahooFinanceService implements FinanceServiceInterface
{
    public function __construct(
        private readonly YahooFinanceClient $client
    ) {
    }

    public function getCompanyPricesByDates(GetCompanyPricesByDatesDto $dto): array
    {
        $pricesRaw = $this->client->getHistoricalData($dto->symbol)->prices;

        $startDateTimeStamp = (clone $dto->startDate)->setTime(0, 0, 0)->getTimestamp();
        $endDateTimeStamp = (clone $dto->endDate)->setTime(23, 59, 59)->getTimestamp();

        $prices = [];
        foreach ($pricesRaw as $price) {
            if (($startDateTimeStamp <= $price->date) && ($price->date <= $endDateTimeStamp)) {
                $prices[] = new Price(
                    date: (new \DateTime())->setTimestamp($price->date),
                    open: $price->open,
                    high: $price->high,
                    low: $price->low,
                    close: $price->close,
                    volume: $price->volume
                );
            }
        }

        return $prices;
    }
}
