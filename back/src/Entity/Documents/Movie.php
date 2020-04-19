<?php

namespace App\Entity\Documents;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\MovieDto;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Class Movie
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 * @ORM\Table(name="document_movie")
 * @ApiResource(
 *     shortName="Movie",
 *     collectionOperations={"get"},
 *     itemOperations={"get"={"security"="object.getVisibility() == true or object.getOwner() == user"}},
 *     output=MovieDto::class
 * )
 * @ApiFilter(OrderFilter::class, properties={"name", "genre", "author"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={"name" : "ipartial", "author" : "ipartial"})
 */
class Movie extends Content
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
     * @var Video
     * @ORM\OneToOne(targetEntity="App\Entity\Documents\Video", cascade={"ALL"}, orphanRemoval=true)
     */
    private $video;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Video
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video $video
     * @return Movie
     */
    public function setVideo(Video $video): Movie
    {
        $this->video = $video;
        return $this;
    }
}