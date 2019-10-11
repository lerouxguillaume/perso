<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Class ImageOfTheDay.
 *
 * @ORM\Entity()
 */
class ImageOfTheDay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Exclude()
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     *
     * @var \DateTime
     */
    private $date;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $mediaType;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $serviceVersion;

    /**
     * @ORM\Column(type="text", nullable=false)
     *
     * @var string
     */
    private $explanation;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $copyright;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return ImageOfTheDay
     *
     * @throws \Exception
     */
    public function setDate(?\DateTime $date): ImageOfTheDay
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return ImageOfTheDay
     */
    public function setTitle(?string $title): ImageOfTheDay
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    /**
     * @param string $mediaType
     *
     * @return ImageOfTheDay
     */
    public function setMediaType(?string $mediaType): ImageOfTheDay
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceVersion(): ?string
    {
        return $this->serviceVersion;
    }

    /**
     * @param string $serviceVersion
     *
     * @return ImageOfTheDay
     */
    public function setServiceVersion(?string $serviceVersion): ImageOfTheDay
    {
        $this->serviceVersion = $serviceVersion;

        return $this;
    }

    /**
     * @return string
     */
    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    /**
     * @param string $explanation
     *
     * @return ImageOfTheDay
     */
    public function setExplanation(?string $explanation): ImageOfTheDay
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return ImageOfTheDay
     */
    public function setUrl(?string $url): ImageOfTheDay
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     *
     * @return ImageOfTheDay
     */
    public function setCopyright(?string $copyright): ImageOfTheDay
    {
        $this->copyright = $copyright;

        return $this;
    }
}
