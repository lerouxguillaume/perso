<?php


namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\ContentDto;

/**
 * Class MovieDto
 * @package App\Controller
 * @ApiResource(
 *     shortName="Movie",
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 */
class MovieDto extends ContentDto
{
    /**
     * @ApiProperty(identifier=true)
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $videoUrl;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return MovieDto
     */
    public function setId(int $id): MovieDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     * @return MovieDto
     */
    public function setVideoUrl(?string $videoUrl): MovieDto
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }
}