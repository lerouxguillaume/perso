<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TimeSerie
 * @package App\Entity
 * @ORM\Entity()
 */
class TimeSerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Exclude()
     * @var int
     */
    private $id;

    /**
     * @var Entreprise
     * @ORM\ManyToOne(targetEntity="Entreprise")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $entreprise;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private $timestamp;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @var float
     */
    private $open;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @var float
     */
    private $close;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @var float
     */
    private $high;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @var float
     */
    private $low;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @var float
     */
    private $volume;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param Entreprise $entreprise
     * @return TimeSerie
     */
    public function setEntreprise($entreprise): TimeSerie
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return TimeSerie
     */
    public function setTimestamp($timestamp): TimeSerie
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return float
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param float $open
     * @return TimeSerie
     */
    public function setOpen($open): TimeSerie
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return float
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @param float $close
     * @return TimeSerie
     */
    public function setClose($close): TimeSerie
    {
        $this->close = $close;
        return $this;
    }

    /**
     * @return float
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @param float $high
     * @return TimeSerie
     */
    public function setHigh($high): TimeSerie
    {
        $this->high = $high;
        return $this;
    }

    /**
     * @return float
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * @param float $low
     * @return TimeSerie
     */
    public function setLow($low): TimeSerie
    {
        $this->low = $low;
        return $this;
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param int $volume
     * @return TimeSerie
     */
    public function setVolume($volume): TimeSerie
    {
        $this->volume = $volume;
        return $this;
    }
}