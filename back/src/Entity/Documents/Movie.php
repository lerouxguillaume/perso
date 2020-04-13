<?php

namespace App\Entity\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Movie
 * @ORM\Entity()
 * @ORM\Table(name="document_movie")
 */
class Movie extends Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

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
     * @return Video
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video $video
     * @return Movie
     */
    public function setVideo(Video $video): Movie
    {
        $this->video = $video;
        return $this;
    }
}