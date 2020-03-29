<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Serie
 * @package App\Entity
 * @ORM\Entity()
 */
class Serie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $season;

    /**
     * @var Video[]
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="serie")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $episodes;

    /**
     * Serie constructor.
     * @param Video[] $episodes
     */
    public function __construct()
    {
        $this->episodes = new PersistentCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Serie
     */
    public function setName(string $name): Serie
    {
        $this->name = $name;
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
     * @return Serie
     */
    public function setDescription(string $description): Serie
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
     * @return Serie
     */
    public function setAuthor(string $author): Serie
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeason(): int
    {
        return $this->season;
    }

    /**
     * @param int $season
     * @return Serie
     */
    public function setSeason(int $season): Serie
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return Video[]
     */
    public function getEpisodes() : PersistentCollection
    {
        return $this->episodes;
    }

    /**
     * @param Video[] $episodes
     * @return Serie
     */
    public function setEpisodes(array $episodes): Serie
    {
        $this->episodes = $episodes;
        return $this;
    }

    /**
     * @param Video $episode
     * @return $this
     */
    public function addEpisode(Video $episode): Serie
    {
        $this->episodes->add($episode);
        return $this;
    }
}