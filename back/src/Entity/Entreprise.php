<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entreprise.
 *
 * @ORM\Entity()
 */
class Entreprise
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
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $raison_sociale;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $trading_location;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raison_sociale;
    }

    /**
     * @param string $raison_sociale
     *
     * @return Entreprise
     */
    public function setRaisonSociale($raison_sociale): Entreprise
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Entreprise
     */
    public function setCode($code): Entreprise
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getTradingLocation()
    {
        return $this->trading_location;
    }

    /**
     * @param string $trading_location
     *
     * @return Entreprise
     */
    public function setTradingLocation($trading_location): Entreprise
    {
        $this->trading_location = $trading_location;

        return $this;
    }
}
