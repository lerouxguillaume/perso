<?php

namespace App\DataProvider\Hydrator;

use App\Controller\MovieDto;
use App\Entity\Documents\Movie;

class MovieHydrator
{
    public function hydrate(Movie $movie)
    {
        $dto = new MovieDto();
        $dto
            ->setId($movie->getId())
            ->setName($movie->getName())
            ->setGenre($movie->getGenre())
            ->setDescription($movie->getDescription())
            ->setAuthor($movie->getAuthor())
            ->setVisibility($movie->getVisibility())
        ;
        return $dto;
    }
}