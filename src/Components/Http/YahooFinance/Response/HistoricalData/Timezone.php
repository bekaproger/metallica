<?php

namespace App\Components\Http\YahooFinance\Response\HistoricalData;

class Timezone
{
    public function __construct(
        public readonly ?int $gmtOffset
    ) {
    }
}