<?php

namespace App\Components\Http\YahooFinance\Response\HistoricalData;

class HistoricalData
{
    public function __construct(
        /** @var array<int, Price> */
        public readonly array $prices,
        public readonly ?bool $isPending = null,
        public readonly ?int $firstTradeDate = null,
        public readonly ?string $id = null,
        public readonly ?Timezone $timezone = null,
        public readonly ?array $eventData = null,
    ) {
    }
}
