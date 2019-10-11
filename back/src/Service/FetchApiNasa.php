<?php

namespace App\Service;

use App\Entity\ImageOfTheDay;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Exception;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class FetchApiNasa
{
    const IMAGE_OF_THE_DAY_URL = '/planetary/apod';

    /** @var LoggerInterface */
    private $logger;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $baseUrl;

    /**
     * FetchApiNasa constructor.
     *
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $em
     * @param string                 $baseUrl
     * @param string                 $apiKey
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, string $baseUrl, string $apiKey)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param DateTime $day
     *
     * @return ImageOfTheDay
     *
     * @throws Exception
     */
    public function getImageOfTheDay(DateTime $day = null)
    {
        $day = $day ?? new DateTime('now');
        $todayImage = $this->em->getRepository(ImageOfTheDay::class)
            ->findOneByDate($day);
        if (empty($todayImage)) {
            $client = new Client();
            try {
                $response = $client->get($this->baseUrl.self::IMAGE_OF_THE_DAY_URL, [
                    'query' => [
                        'api_key' => $this->apiKey,
                        'date' => $day->format('Y-m-d'),
                        'concept_tags' => true,
                    ],
                ]);
                $this->logger->info(
                    'fetch image of the day : '.$day->format('d/m/Y')
                );
            } catch (Exception $e) {
                $this->logger->error('An error occured with the api call', [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ]);
                throw new ErrorException($e->getMessage());
            }
            $content = json_decode($response->getBody()->getContents());

            $todayImage = new ImageOfTheDay();

            $todayImage
                ->setDate(!empty($content->date) ? new DateTime($content->date) : null)
                ->setTitle($content->title ?? null)
                ->setMediaType($content->media_type ?? null)
                ->setServiceVersion($content->service_version ?? null)
                ->setExplanation($content->explanation ?? null)
                ->setUrl($content->url ?? null)
                ->setCopyright($content->copyright ?? null)
            ;

            $this->em->persist($todayImage);
            $this->em->flush();
        }

        $this->logger->info(
            'get image of the day : '.$day->format('d/m/Y')
        );

        return $todayImage;
    }
}
