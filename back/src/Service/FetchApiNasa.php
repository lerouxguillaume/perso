<?php

namespace App\Service;

use App\Entity\ImageOfTheDay;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class FetchApiNasa
{
    /** @var LoggerInterface */
    private $logger;

    /** @var string  */
    private $apiKey = '8lX4TQt2X1QyPsAWJaveWG1gOarMaFdauOb3x3bx';

    /**
     * FetchApiNasa constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function getImageOfTheDay()
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.nasa.gov/planetary/apod', [
                'query' => ['api_key' => $this->apiKey, 'concept_tags' => true]
        ]);
        } catch (\Exception $e) {
            $this->logger->error('An error occured with the api call', [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }

        $content = json_decode($response->getBody()->getContents());
        $imageOfTheDay = new ImageOfTheDay($content);
        return $imageOfTheDay;
    }
}