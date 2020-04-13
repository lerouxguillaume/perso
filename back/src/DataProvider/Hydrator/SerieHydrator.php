<?php


namespace App\DataProvider\Hydrator;


use App\DTO\SerieDto;
use App\Entity\Documents\Serie;

class SerieHydrator
{
    /** @var EpisodeHydrator  */
    private $episodeHydrator;

    /**
     * SerieHydrator constructor.
     * @param EpisodeHydrator $episodeHydrator
     */
    public function __construct(EpisodeHydrator $episodeHydrator)
    {
        $this->episodeHydrator = $episodeHydrator;
    }

    public function hydrate(Serie $serie)
    {
        $dto = new SerieDto();
        $dto
            ->setId($serie->getId())
            ->setSeason($serie->getSeason())
            ->setName($serie->getName())
            ->setAuthor($serie->getAuthor())
            ->setDescription($serie->getDescription())
            ->setGenre($serie->getGenre())
            ->setVisibility($serie->getVisibility())
        ;
        $episodes = [];
        foreach ($serie->getEpisodes() as $episode) {
            $episodes[] = $this->episodeHydrator->hydrate($episode);
        }
        $dto->setEpisodes($episodes);
        return $dto;
    }
}