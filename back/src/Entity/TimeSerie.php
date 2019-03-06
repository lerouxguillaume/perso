<?php

namespace App\Entity;

class TimeSerie
{
    /** @var int */
    private $timestamp;

    /** @var float */
    private $open;

    /** @var float */
    private $close;

    /** @var float */
    private $high;

    /** @var float */
    private $low;

    /** @var int */
    private $volume;

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