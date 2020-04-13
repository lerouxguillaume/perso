<?php


namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class SerieDto
 * @package App\DTO
 * @ApiResource(
 *     shortName="Serie",
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 */
class SerieDto extends ContentDto
{
    /**
     * @ApiProperty(identifier=true)
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $season;

    /**
     * @var EpisodeDto[]
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
     * @return EpisodeDto[]
     */
    public function getEpisodes(): ?array
    {
        return $this->episodes;
    }

    /**
     * @param EpisodeDto[] $episodes
     * @return SerieDto
     */
    public function setEpisodes(?array $episodes): SerieDto
    {
        $this->episodes = $episodes;
        return $this;
    }
}