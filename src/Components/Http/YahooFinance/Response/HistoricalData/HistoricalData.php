<?php

namespace App\Components\Http\YahooFinance\Response\HistoricalData;

class HistoricalData
{
    public function __construct(
        /** @var array<int, Price> */
        public readonly array $prices,
        public readonly ?bool $isPending,
        public readonly ?int $firstTradeDate,
        public readonly ?string $id,
        public readonly ?Timezone $timezone,
        public readonly ?array $eventData,
    ) {
    }
}