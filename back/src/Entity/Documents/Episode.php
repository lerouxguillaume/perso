<?php

namespace App\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Episode
 * @ORM\Entity()
 * @ORM\Table(name="document_episode")
 */
class Episode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $episode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var Serie
     * @ORM\ManyToOne(targetEntity="App\Entity\Documents\Serie", inversedBy="episodes")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $serie;

    /**
     * @var Video
     * @ORM\OneToOne(targetEntity="App\Entity\Documents\Video", cascade={"ALL"}, orphanRemoval=true)
     */
    private $video;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

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

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Episode
     */
    public function setName(string $name): Episode
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Video
     */
    public function getVideo(): Video
    {
        return $this->video;
    }

    /**
     * @param Video $video
     * @return Episode
     */
    public function setVideo(Video $video): Episode
    {
        $this->video = $video;
        return $this;
    }
}