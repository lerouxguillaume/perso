<?php

namespace App\Dto;

/**
 * Class MovieDto
 * @package App\Controller
 */
class MovieDto extends ContentDto
{
    /**
     * @var int
     */
    private $id;

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
     * @return MovieDto
     */
    public function setId(int $id): MovieDto
    {
        $this->id = $id;
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
     * @return MovieDto
     */
    public function setVideoUrl(?string $videoUrl): MovieDto
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }
}