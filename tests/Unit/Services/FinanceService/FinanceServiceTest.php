<?php

namespace App\Tests\Unit\Services\FinanceService;

use App\Components\Http\YahooFinance\YahooFinanceClient;
use App\Dto\GetCompanyPricesByDatesDto;
use App\Services\FinanceService\YahooFinanceService;
use App\Tests\TestServices\TestYahooFinanceService;
use PHPUnit\Framework\TestCase;

class FinanceServiceTest extends TestCase
{
    private TestYahooFinanceService $yahooFinanceService;

    public function setUp(): void
    {
        parent::setUp();
        $this->yahooFinanceService = new TestYahooFinanceService();
    }

    public function testGettingHistoricalData()
    {
        $startDate = (new \DateTime())->setTime(0, 0, 0);
        $pricesCount = 10;

        $prices = $this->yahooFinanceService->createHistoricalPricesResponse(clone $startDate, $pricesCount);

        $symbol = 'TEST';

        $financeClientMock = $this->createMock(YahooFinanceClient::class);
        $financeClientMock
            ->expects($this->once())
            ->method('getHistoricalData')
            ->with($this->equalTo($symbol), $this->equalTo(null))
            ->willReturn($prices);

        $financeServiceMock = new YahooFinanceService($financeClientMock);

        $res = $financeServiceMock->getCompanyPricesByDates(new GetCompanyPricesByDatesDto(
            $symbol,
            (clone $startDate)->add(new \DateInterval('P1D')),
            (clone $startDate)->add(new \DateInterval('P' . $pricesCount - 2 . 'D'))
        ));

        $this->assertCount($pricesCount - 2, $res);

        for ($i = 0; $i < $pricesCount - 2; $i++) {
            $testPrice = $prices->prices[$i + 1];
            $servicePrice = $res[$i];
            $this->assertEquals($testPrice->date, $servicePrice->getDate()->getTimestamp());
            $this->assertEquals($testPrice->high, $servicePrice->getHigh());
            $this->assertEquals($testPrice->open, $servicePrice->getOpen());
            $this->assertEquals($testPrice->low, $servicePrice->getLow());
            $this->assertEquals($testPrice->close, $servicePrice->getClose());
            $this->assertEquals($testPrice->volume, $servicePrice->getVolume());
        }
    }
}
