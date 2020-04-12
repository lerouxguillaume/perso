<?php

namespace App\Entity\Documents;

use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Serie
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="document_serie")
 */
class Serie extends Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $season;

    /**
     * @var Episode[]
     * @ORM\OneToMany(targetEntity="App\Entity\Documents\Episode", mappedBy="serie")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $episodes;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return PersistentCollection
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
     * @param Episode $episode
     * @return $this
     */
    public function addEpisode(Episode $episode): Serie
    {
        $this->episodes->add($episode);
        return $this;
    }
}