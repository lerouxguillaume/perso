<?php

namespace App\Service;

use App\Entity\ImageOfTheDay;
use App\Entity\OHLCFormat;
use App\Entity\TimeSerie;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class FetchApiAlphaVantage
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string  */
    private $apiKey = 'GEA2QS5WI2IM8WOF';

    /**
     * FetchApiNasa constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    public function getDailyCotes(string $symbol)
    {
        $client = new Client();
        try {
            $response = $client->get('https://www.alphavantage.co/query', [
                'query' => [
                    'function' => 'TIME_SERIES_DAILY',
                    'symbol' => $symbol.'.PA',
                    'apikey' => $this->apiKey,
                ]
            ]);
            $this->logger->info(
                'fetch daily cotes for : '. $symbol
            );
        } catch (\Exception $e) {
            $this->logger->error('An error occured with the api call', [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
        $content = json_decode($response->getBody()->getContents(), true);
        $res = [];
        foreach ($content['Time Series (Daily)'] as $time => $ohlc) {
            $currentOhlc = new OHLCFormat();
            $currentOhlc
                ->setOpen(floatval($ohlc['1. open']))
                ->setHigh(floatval($ohlc['2. high']))
                ->setLow(floatval($ohlc['3. low']))
                ->setClose(floatval($ohlc['4. close']))
            ;
            $currentTimestamp = (new \DateTime($time))->getTimestamp();
            $currentTimeSerie = new TimeSerie();
            $currentTimeSerie
                ->setOhlcFormat($currentOhlc)
                ->setVolume($ohlc['5. volume'])
                ->setTimestamp($currentTimestamp)
            ;
            $res[] = $currentTimeSerie;
        }

        return $res;
    }
}