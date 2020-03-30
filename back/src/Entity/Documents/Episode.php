<?php

namespace App\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Episode
 * @ORM\Entity()
 * @ORM\Table(name="document_episode")
 */
class Episode extends Video
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $episode;

    /**
     * @var Serie
     * @ORM\ManyToOne(targetEntity="App\Entity\Documents\Serie", inversedBy="episodes")
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
     * @return Episode
     */
    public function setEpisode(int $episode): Episode
    {
        $this->episode = $episode;
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
     * @return Episode
     */
    public function setSerie(Serie $serie): Episode
    {
        $this->serie = $serie;
        return $this;
    }
}