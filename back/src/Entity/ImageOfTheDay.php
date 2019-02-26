<?php

namespace App\Entity;

/**
 * Class ImageOfTheDay
 * @package App\Entity
 */
class ImageOfTheDay
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $mediaType;

    /**
     * @var string
     */
    private $serviceVersion;

    /**
     * @var string
     */
    private $explanation;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $copyright;

    /**
     * ImageOfTheDay constructor.
     * @param null $object
     * @throws \Exception
     */
    public function __construct($object = null) {
        if ($object !== null) {
            $this
                ->setDate($object->date ?? null)
                ->setTitle($object->title ?? null)
                ->setMediaType($object->media_type ?? null)
                ->setServiceVersion($object->service_version ?? null)
                ->setExplanation($object->explanation ?? null)
                ->setUrl($object->url ?? null)
                ->setCopyright($object->copyright ?? null);
        }
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function setDate($date): ImageOfTheDay
    {
        if ($date instanceof \DateTime) {
            $this->date = $date;
        } elseif (!empty($date)) {
            $this->date = new \DateTime($date);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ImageOfTheDay
     */
    public function setTitle($title): ImageOfTheDay
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @param string $mediaType
     * @return ImageOfTheDay
     */
    public function setMediaType($mediaType): ImageOfTheDay
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceVersion()
    {
        return $this->serviceVersion;
    }

    /**
     * @param string $serviceVersion
     * @return ImageOfTheDay
     */
    public function setServiceVersion($serviceVersion): ImageOfTheDay
    {
        $this->serviceVersion = $serviceVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * @param string $explanation
     * @return ImageOfTheDay
     */
    public function setExplanation($explanation): ImageOfTheDay
    {
        $this->explanation = $explanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ImageOfTheDay
     */
    public function setUrl($url): ImageOfTheDay
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     * @return ImageOfTheDay
     */
    public function setCopyright($copyright): ImageOfTheDay
    {
        $this->copyright = $copyright;
        return $this;
    }
}