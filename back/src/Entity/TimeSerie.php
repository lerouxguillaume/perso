<?php

namespace App\Entity;

class TimeSerie
{
    /** @var int */
    private $timestamp;

    /** @var OHLCFormat */
    private $ohlcFormat;

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
     * @return OHLCFormat
     */
    public function getOhlcFormat()
    {
        return $this->ohlcFormat;
    }

    /**
     * @param OHLCFormat $ohlcFormat
     * @return TimeSerie
     */
    public function setOhlcFormat($ohlcFormat): TimeSerie
    {
        $this->ohlcFormat = $ohlcFormat;
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