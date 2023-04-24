<?php

namespace App\Services\FinanceService;

use App\Dto\GetCompanyPricesByDatesDto;
use App\Services\FinanceService\Entity\Price;

interface FinanceServiceInterface
{
    /**
     * @param GetCompanyPricesByDatesDto $dto
     * @return array<int, Price>
     */
    public function getCompanyPricesByDates(GetCompanyPricesByDatesDto $dto): array;
}