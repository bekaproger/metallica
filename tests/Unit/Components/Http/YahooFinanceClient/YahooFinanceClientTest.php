<?php

namespace App\Tests\Unit\Components\YahooFinanceClient;

use App\Components\Http\YahooFinance\Exceptions\YahooFinanceException;
use App\Components\Http\YahooFinance\YahooFinanceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class YahooFinanceClientTest extends TestCase
{
    private array $requestTransactions = [];

    private MockHandler $mockHandler;

    private Client $client;

    private const URI = 'http://test.com';

    private const API_KEY = 'test';

    private const HOST = 'test.host';

    public function setUp(): void
    {
        parent::setUp();
        $history = Middleware::history($this->requestTransactions);

        $this->mockHandler = new MockHandler([]);

        $handlerStack = HandlerStack::create($this->mockHandler);

        $handlerStack->push($history);

        $this->client = new Client([
            'baser_uri' => self::URI,
            'headers' => [
                'X-RapidAPI-Key' => self::API_KEY,
                'X-RapidAPI-Host' => self::HOST,
            ],
            'handler' => $handlerStack,
        ]);
    }

    public function testGetHistoricalData()
    {
        $data = [
            'prices' => [[
                'date' => 1653312600,
                'open' => 1.4500000476837158,
                'high' => 1.4700000286102295,
                'low' => 1.399999976158142,
                'close' => 1.409999966621399,
                'volume' => 1702200,
                'adjclose' => 1.409999966621399,
            ]],
            'isPending' => false,
            'firstTradeDate' => 733674600,
            'id' => '',
            'timeZone' => [
                'gmtOffset' => -14400,
            ],
            'eventsData' => [],
        ];

        $this->mockHandler->append(new Response(200,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        ));

        $client = new YahooFinanceClient($this->client);
        $testSymbol = 'test';
        $res = $client->getHistoricalData($testSymbol);

        $this->assertCount(1, $this->requestTransactions);
        $this->assertCount(count($data['prices']), $res->prices);

        foreach ($res->prices as $key => $price) {
            $dataPrice = $data['prices'][$key];
            $this->assertEquals($dataPrice['date'], $price->date);
            $this->assertEquals($dataPrice['open'], $price->open);
            $this->assertEquals($dataPrice['high'], $price->high);
            $this->assertEquals($dataPrice['low'], $price->low);
            $this->assertEquals($dataPrice['close'], $price->close);
            $this->assertEquals($dataPrice['volume'], $price->volume);
        }

        $this->assertEquals($data['isPending'], $res->isPending);
        $this->assertEquals($data['firstTradeDate'], $res->firstTradeDate);
        $this->assertEquals($data['id'], $res->id);

        /** @var Request $request */
        $request = $this->requestTransactions[0]['request'];

        $this->assertEquals(self::API_KEY, $request->getHeader('X-RapidAPI-Key')[0]);
        $this->assertEquals(self::HOST, $request->getHeader('X-RapidAPI-Host')[0]);
    }

    public function testException()
    {
        $this->mockHandler->append(new Response(500));

        $client = new YahooFinanceClient($this->client);
        $this->expectException(YahooFinanceException::class);
        $client->getHistoricalData('test');
    }
}
