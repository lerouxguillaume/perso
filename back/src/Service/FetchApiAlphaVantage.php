<?php

namespace App\Service;

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
        return $this->em->getRepository(Entreprise::class)->findAll();
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
            ->modify('-10 year')->getTimestamp();
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
}