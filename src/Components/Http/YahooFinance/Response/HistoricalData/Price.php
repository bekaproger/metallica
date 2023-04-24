<?php

declare(strict_types=1);

namespace App\Components\Http\YahooFinance\Response\HistoricalData;

class Price
{
    public function __construct(
        public readonly int $date,
        public readonly float $open,
        public readonly float $high,
        public readonly float $low,
        public readonly float $close,
        public readonly int $volume,
        public readonly ?float $adjClose
    ) {
    }
}
