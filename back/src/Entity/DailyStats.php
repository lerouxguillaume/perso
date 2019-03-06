<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DailyStats
 * @package App\Entity
 * @ORM\Entity()
 */
class DailyStats
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
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $day;

    /**
     * @var Entreprise
     * @ORM\ManyToOne(targetEntity="Entreprise")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $entreprise;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $dayVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $weekVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $monthVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $trimesterVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $yearVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $fiveYearVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $tenYearVariance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $indiceConfiance;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param \DateTime $day
     * @return DailyStats
     */
    public function setDay($day): DailyStats
    {
        $this->day = $day;
        return $this;
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
     * @return DailyStats
     */
    public function setEntreprise($entreprise): DailyStats
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    /**
     * @return float
     */
    public function getDayVariance()
    {
        return $this->dayVariance;
    }

    /**
     * @param float $dayVariance
     * @return DailyStats
     */
    public function setDayVariance($dayVariance): DailyStats
    {
        $this->dayVariance = $dayVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeekVariance()
    {
        return $this->weekVariance;
    }

    /**
     * @param float $weekVariance
     * @return DailyStats
     */
    public function setWeekVariance($weekVariance): DailyStats
    {
        $this->weekVariance = $weekVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getMonthVariance()
    {
        return $this->monthVariance;
    }

    /**
     * @param float $monthVariance
     * @return DailyStats
     */
    public function setMonthVariance($monthVariance): DailyStats
    {
        $this->monthVariance = $monthVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getTrimesterVariance()
    {
        return $this->trimesterVariance;
    }

    /**
     * @param float $trimesterVariance
     * @return DailyStats
     */
    public function setTrimesterVariance($trimesterVariance): DailyStats
    {
        $this->trimesterVariance = $trimesterVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getYearVariance()
    {
        return $this->yearVariance;
    }

    /**
     * @param float $yearVariance
     * @return DailyStats
     */
    public function setYearVariance($yearVariance): DailyStats
    {
        $this->yearVariance = $yearVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getFiveYearVariance()
    {
        return $this->fiveYearVariance;
    }

    /**
     * @param float $fiveYearVariance
     * @return DailyStats
     */
    public function setFiveYearVariance($fiveYearVariance): DailyStats
    {
        $this->fiveYearVariance = $fiveYearVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getTenYearVariance()
    {
        return $this->tenYearVariance;
    }

    /**
     * @param float $tenYearVariance
     * @return DailyStats
     */
    public function setTenYearVariance($tenYearVariance): DailyStats
    {
        $this->tenYearVariance = $tenYearVariance;
        return $this;
    }

    /**
     * @return float
     */
    public function getIndiceConfiance()
    {
        return $this->indiceConfiance;
    }

    /**
     * @param float $indiceConfiance
     * @return DailyStats
     */
    public function setIndiceConfiance($indiceConfiance): DailyStats
    {
        $this->indiceConfiance = $indiceConfiance;
        return $this;
    }
}