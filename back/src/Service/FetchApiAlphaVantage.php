<?php

namespace App\Service;

use App\Entity\DailyStats;
use App\Entity\Entreprise;
use App\Entity\TimeSerie;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function getEntreprises()
    {
        /** @var Entreprise $entreprise */
        $entreprises = $this->em->getRepository(Entreprise::class)->findAll();


        $res = [];

        foreach ($entreprises as $entreprise) {
            $todayTimestamp = $this->em->getRepository(TimeSerie::class)
                ->findLastTimeSerieTimestamp($entreprise);
            $yesterdayTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 day')->getTimestamp();
            $weekAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 week')->getTimestamp();
            $monthAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 month')->getTimestamp();
            $trimesterAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-3 month')->getTimestamp();
            $yearAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 year')->getTimestamp();
            $fiveYearAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-5 year')->getTimestamp();
            $tenYearAgoTimestamp = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-10 year')->getTimestamp();

            $dailyStats = $this->em->getRepository(TimeSerie::class)->findBy([
                'entreprise' => $entreprise,
                'timestamp' => [
                    $todayTimestamp,
                    $yesterdayTimestamp,
                    $weekAgoTimestamp,
                    $monthAgoTimestamp,
                    $trimesterAgoTimestamp,
                    $yearAgoTimestamp,
                    $fiveYearAgoTimestamp,
                    $tenYearAgoTimestamp
                ]
            ]);

            $currentDailyStat = new DailyStats();

            $currentDailyStat->setEntreprise($entreprise);
            $todayTimeSerie = null;
            $yesterdayTimeSerie = null;
            $weekAgoTimeSerie = null;
            $monthAgoTimeSerie = null;
            $trimesterAgoTimeSerie = null;
            $yearAgoTimeSerie = null;
            $fiveYearAgoTimeSerie = null;
            $tenYearAgoTimeSerie = null;

            /** @var TimeSerie $dailyStat */
            foreach ($dailyStats as $dailyStat) {
                switch ($dailyStat->getTimestamp()) {
                    case $todayTimestamp:
                        $todayTimeSerie = $dailyStat;
                        break;
                    case $yesterdayTimestamp:
                        $yesterdayTimeSerie = $dailyStat;
                        break;
                    case $weekAgoTimestamp:
                        $weekAgoTimeSerie = $dailyStat;
                        break;
                    case $monthAgoTimestamp:
                        $monthAgoTimeSerie = $dailyStat;
                        break;
                    case $trimesterAgoTimestamp:
                        $trimesterAgoTimeSerie = $dailyStat;
                        break;
                    case $yearAgoTimestamp:
                        $yearAgoTimeSerie = $dailyStat;
                        break;
                    case $fiveYearAgoTimestamp:
                        $fiveYearAgoTimeSerie = $dailyStat;
                        break;
                    case $tenYearAgoTimestamp:
                        $tenYearAgoTimeSerie = $dailyStat;
                        break;
                }
            }

            if (!empty($yesterdayTimeSerie)) {
                $currentDailyStat->setDayVariance($this->getPercentIncrease($todayTimeSerie, $yesterdayTimeSerie));
            }
            if (!empty($weekAgoTimeSerie)) {
                $currentDailyStat->setWeekVariance($this->getPercentIncrease($todayTimeSerie, $weekAgoTimeSerie));
            }
            if (!empty($monthAgoTimeSerie)) {
                $currentDailyStat->setMonthVariance($this->getPercentIncrease($todayTimeSerie, $monthAgoTimeSerie));
            }
            if (!empty($trimesterAgoTimeSerie)) {
                $currentDailyStat->setTrimesterVariance($this->getPercentIncrease($todayTimeSerie, $trimesterAgoTimeSerie));
            }
            if (!empty($yearAgoTimeSerie)) {
                $currentDailyStat->setYearVariance($this->getPercentIncrease($todayTimeSerie, $yearAgoTimeSerie));
            }
            if (!empty($fiveYearAgoTimeSerie)) {
                $currentDailyStat->setFiveYearVariance($this->getPercentIncrease($todayTimeSerie, $fiveYearAgoTimeSerie));
            }
            if (!empty($tenYearAgoTimeSerie)) {
                $currentDailyStat->setTenYearVariance($this->getPercentIncrease($todayTimeSerie, $tenYearAgoTimeSerie));
            }
            $res[] = $currentDailyStat;
        }
        return $res;
    }

    public function getDailyCotes(string $symbol)
    {
        /** @var Entreprise $entreprise */
        $entreprise = $this->em->getRepository(Entreprise::class)->findOneBy(['code' => $symbol]);
        if (empty($entreprise)) {
            throw new NotFoundHttpException();
        }
        $client = new Client();
        try {
            $response = $client->get('https://www.alphavantage.co/query', [
                'query' => [
                    'function' => 'TIME_SERIES_DAILY',
                    'symbol' => $entreprise->getCode().'.'.$entreprise->getTradingLocation(),
                    'apikey' => $this->apiKey,
                    'outputsize' => 'full',
                ]
            ]);
            $this->logger->info(
                'fetch daily cotes for : '. $entreprise->getRaisonSociale()
            );
        } catch (\Exception $e) {
            $this->logger->error('An error occured with the api call', [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
        $content = json_decode($response->getBody()->getContents(), true);
        $res = [];
        $tenyearAgoTimestamp = (new \DateTime())->setTimestamp(strtotime('today midnight'))
            ->modify('-10 year -1 day')->getTimestamp();
        if (!isset($content['Time Series (Daily)'])) {
            $this->logger->error('An error occured with the api call', [
                'message' => $content
            ]);
        }
        foreach ($content['Time Series (Daily)'] as $time => $ohlc) {
            $currentTimestamp = (new \DateTime($time))->getTimestamp();
            if ($currentTimestamp >= $tenyearAgoTimestamp) {
                $currentTimeSerie = new TimeSerie();
                $currentTimeSerie
                    ->setOpen(floatval($ohlc['1. open']))
                    ->setHigh(floatval($ohlc['2. high']))
                    ->setLow(floatval($ohlc['3. low']))
                    ->setClose(floatval($ohlc['4. close']))
                    ->setVolume($ohlc['5. volume'])
                    ->setTimestamp($currentTimestamp);
                $res[] = $currentTimeSerie;
            }
        }
        return $res;
    }

    private function getPercentIncrease(TimeSerie $new, TimeSerie $old)
    {
        return $new->getClose()*100/$old->getClose()-100;
    }
}