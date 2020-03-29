<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Video
 * @package App\Entity
 * @ORM\Entity()
 */
class Video extends Document
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $episode;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $genre;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $author;

    /**
     * @var Serie
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="episodes")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $serie;

    /**
     * @return int
     */
    public function getEpisode(): int
    {
        return $this->episode;
    }

    /**
     * @param int $episode
     * @return Video
     */
    public function setEpisode(?int $episode): Video
    {
        $this->episode = $episode;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return Video
     */
    public function setDuration(?int $duration): Video
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return Video
     */
    public function setGenre(string $genre): Video
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Video
     */
    public function setDescription(string $description): Video
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Video
     */
    public function setAuthor(string $author): Video
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Serie
     */
    public function getSerie(): Serie
    {
        return $this->serie;
    }

    /**
     * @param Serie $serie
     * @return Video
     */
    public function setSerie(Serie $serie): Video
    {
        $this->serie = $serie;
        return $this;
    }
}