<?php

namespace App\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="document_video")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Video extends Document
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

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
}