<?php

namespace App\Service;

use App\Entity\ImageOfTheDay;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\ServerException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class FetchApiNasa
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string  */
    private $apiKey = '8lX4TQt2X1QyPsAWJaveWG1gOarMaFdauOb3x3bx';

    /**
     * FetchApiNasa constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    /**
     * @param \DateTime $day
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function getImageOfTheDay(\DateTime $day = null)
    {
        $day = $day ?? new \DateTime('now');
        $todayImage = $this->em->getRepository(ImageOfTheDay::class)
            ->findOneByDate($day);
        if (empty($todayImage)) {
            $client = new Client();
            try {
                $response = $client->get('https://api.nasa.gov/planetary/apod', [
                    'query' => [
                        'api_key' => $this->apiKey,
                        'date' => $day->format('Y-m-d'),
                        'concept_tags' => true
                    ]
                ]);
                $this->logger->info(
                    'fetch image of the day : '. $day->format('d/m/Y')
                );
                if ($remaining = $response->getHeader('X-RateLimit-Remaining')) {
                    if (current($remaining) <= 0) {
                        throw new \OverflowException();
                    }
                }
            } catch (\Exception $e) {
                $this->logger->error('An error occured with the api call', [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
                throw new \ErrorException($e->getMessage());
            }
            $content = json_decode($response->getBody()->getContents());
            $todayImage = new ImageOfTheDay($content);
            $this->em->persist($todayImage);
            $this->em->flush();
        }

        $this->logger->info(
            'get image of the day : '. $day->format('d/m/Y')
        );

        return $todayImage;
    }
}