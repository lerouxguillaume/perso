<?php

namespace App\Service;

use App\Entity\ImageOfTheDay;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function getImageOfTheDay()
    {
        $todayImage = $this->em->getRepository(ImageOfTheDay::class)
            ->findOneByDate(new \DateTime('now'));
        if (empty($todayImage)) {
            $client = new Client();
            try {
                $response = $client->get('https://api.nasa.gov/planetary/apod', [
                    'query' => ['api_key' => $this->apiKey, 'concept_tags' => true]
                ]);
                $this->logger->info(
                    'fetch image of the day : '. (new \DateTime('now'))->format('d/m/Y')
                );
            } catch (\Exception $e) {
                $this->logger->error('An error occured with the api call', [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
            }

            $content = json_decode($response->getBody()->getContents());
            $todayImage = new ImageOfTheDay($content);
            $this->em->persist($todayImage);
            $this->em->flush();
        }

        $this->logger->info(
            'get image of the day : '. (new \DateTime('now'))->format('d/m/Y')
        );

        return $todayImage;
    }
}