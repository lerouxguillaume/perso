<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\MovieDto;
use App\Entity\Documents\Movie;
use App\Service\VideoService;

class MovieOutputDataTransformer implements DataTransformerInterface
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
        /** @var Movie $data */
        $output = new MovieDto();
        $output
            ->setId($data->getId())
            ->setAuthor($data->getAuthor())
            ->setGenre($data->getGenre())
            ->setVisibility($data->getVisibility())
            ->setName($data->getName())
            ->setDescription($data->getDescription())
            ->setVideoUrl($this->videoService->generateUrl($data->getVideo()))
        ;
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return MovieDto::class === $to && $data instanceof Movie;
    }

}