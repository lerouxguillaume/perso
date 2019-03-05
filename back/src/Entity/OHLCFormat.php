<?php

namespace App\Entity;

class OHLCFormat
{
    /** @var float */
    private $open;

    /** @var float */
    private $close;

    /** @var float */
    private $high;

    /** @var float */
    private $low;

    /**
     * @return float
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param float $open
     * @return OHLCFormat
     */
    public function setOpen($open): OHLCFormat
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
     * @return OHLCFormat
     */
    public function setClose($close): OHLCFormat
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
     * @return OHLCFormat
     */
    public function setHigh($high): OHLCFormat
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
     * @return OHLCFormat
     */
    public function setLow($low): OHLCFormat
    {
        $this->low = $low;
        return $this;
    }
}