<?php

namespace App\Entity\Documents;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\SerieDto;

/**
 * Class Serie
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 * @ORM\Table(name="document_serie")
 * @ApiResource(
 *     shortName="Serie",
 *     collectionOperations={"get"},
 *     itemOperations={"get"={"security"="object.getVisibility() == true or object.getOwner() == user"}},
 *     output=SerieDto::class
 * )
 */
class Serie extends Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=true)
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $season;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Documents\Episode", mappedBy="serie")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $episodes;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSeason(): int
    {
        return $this->season;
    }

    /**
     * @param int $season
     * @return Serie
     */
    public function setSeason(int $season): Serie
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getEpisodes() : PersistentCollection
    {
        return $this->episodes;
    }

    /**
     * @param PersistentCollection $episodes
     * @return Serie
     */
    public function setEpisodes(PersistentCollection $episodes): Serie
    {
        $this->episodes = $episodes;
        return $this;
    }

    /**
     * @param Episode $episode
     * @return $this
     */
    public function addEpisode(Episode $episode): Serie
    {
        $this->episodes->add($episode);
        return $this;
    }
}