<?php

namespace App\DataProvider\Hydrator;

use App\DTO\EpisodeDto;
use App\Entity\Documents\Episode;

class EpisodeHydrator
{
    public function hydrate(Episode $episode)
    {
        $dto = new EpisodeDto();
        $dto
            ->setId($episode->getId())
            ->setEpisode($episode->getEpisode())
            ->setName($episode->getName())
        ;
        return $dto;
    }
}