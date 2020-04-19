<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\Collection;

/**
 * Class SerieDto
 * @package App\Dto
 */
class SerieDto extends ContentDto
{
    /**
     * @var int
     * @ApiProperty(identifier=true)
     */
    private $id;

    /**
     * @var int
     */
    private $season;

    /**
     * @var Collection
     */
    private $episodes;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param ?int $id
     * @return SerieDto
     */
    public function setId(?int $id): SerieDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ?int
     */
    public function getSeason(): ?int
    {
        return $this->season;
    }

    /**
     * @param ?int $season
     * @return SerieDto
     */
    public function setSeason(?int $season): SerieDto
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getEpisodes(): ?Collection
    {
        return $this->episodes;
    }

    /**
     * @param Collection $episodes
     * @return SerieDto
     */
    public function setEpisodes(?Collection $episodes): SerieDto
    {
        $this->episodes = $episodes;
        return $this;
    }
}