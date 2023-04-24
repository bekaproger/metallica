<?php

namespace App\Dto;

class GetCompanyPricesByDatesDto
{
    public function __construct(
        public string $symbol,
        public \DateTimeInterface $startDate,
        public \DateTimeInterface $endDate
    ) {
    }
}
