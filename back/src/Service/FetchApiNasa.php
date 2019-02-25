<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class FetchApiNasa
{
    /** @var LoggerInterface */
    private $logger;

    /** @var string  */
    private $apiKey = 'DEMO_KEY';

    /**
     * FetchApiNasa constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getImageOfTheDay()
    {
        $client = new Client();
        $response = $client->get('https://api.nasa.gov/planetary/apod',[
            'api_key' => $this->apiKey
        ]);

        dump($response);die();
    }
}