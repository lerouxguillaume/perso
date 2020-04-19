<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\SerieDto;
use App\Entity\Documents\Serie;

class SerieOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        /** @var Serie $data */
        $output = new SerieDto();

        $output
            ->setId($data->getId())
            ->setName($data->getName())
            ->setDescription($data->getDescription())
            ->setGenre($data->getGenre())
            ->setSeason($data->getSeason())
            ->setAuthor($data->getAuthor())
            ->setVisibility($data->getVisibility())
        ;

        if ($context['operation_type'] === 'item') {
            $output->setEpisodes($data->getEpisodes());
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SerieDto::class === $to && $data instanceof Serie;
    }

}