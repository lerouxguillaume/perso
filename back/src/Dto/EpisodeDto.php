<?php

namespace App\Dto;

use App\Entity\Documents\Serie;

/**
 * Class MovieDto
 * @package App\Controller
 */
class EpisodeDto
{
    /**
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
     * @var string
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
     * @return Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param Serie $serie
     * @return EpisodeDto
     */
    public function setSerie($serie): EpisodeDto
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