<?php

namespace App\Dto;

use DateTimeInterface;

class GetCompanyPricesByDatesDto
{
    public function __construct(
        public string $symbol,
        public DateTimeInterface $startDate,
        public DateTimeInterface $endDate
    ) {
    }
}