<?php


namespace App\DTO;


use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class MovieDto
 * @package App\Controller
 * @ApiResource(
 *     shortName="Episode",
 *     collectionOperations={},
 *     itemOperations={"get"}
 * )
 */
class EpisodeDto
{
    /**
     * @ApiProperty(identifier=true)
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $episode;

    /**
     * @var string
     */
    private $name;

    /**
     * @var SerieDto
     */
    private $serie;

    /**
     * @var string
     */
    private $videoUrl;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return EpisodeDto
     */
    public function setId(int $id): EpisodeDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getEpisode(): ?int
    {
        return $this->episode;
    }

    /**
     * @param int $episode
     * @return EpisodeDto
     */
    public function setEpisode(?int $episode): EpisodeDto
    {
        $this->episode = $episode;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EpisodeDto
     */
    public function setName(?string $name): EpisodeDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return SerieDto
     */
    public function getSerie(): ?SerieDto
    {
        return $this->serie;
    }

    /**
     * @param SerieDto $serie
     * @return EpisodeDto
     */
    public function setSerie(SerieDto $serie): EpisodeDto
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     * @return EpisodeDto
     */
    public function setVideoUrl(string $videoUrl): EpisodeDto
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }
}