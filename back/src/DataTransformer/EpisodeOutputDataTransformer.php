<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\EpisodeDto;
use App\Dto\SerieDto;
use App\Entity\Documents\Episode;
use App\Service\VideoService;

class EpisodeOutputDataTransformer implements DataTransformerInterface
{
    /** @var VideoService */
    private $videoService;

    /**
     * MovieOutputDataTransformer constructor.
     * @param VideoService $videoService
     */
    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        /** @var Episode $data */
        $output = new EpisodeDto();
        $output
            ->setId($data->getId())
            ->setName($data->getName())
            ->setEpisode($data->getEpisode())
            ->setVideoUrl($this->videoService->generateUrl($data->getVideo()))
//            ->setSerie($data->getSerie())
        ;
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return EpisodeDto::class === $to && $data instanceof Episode;
    }

}