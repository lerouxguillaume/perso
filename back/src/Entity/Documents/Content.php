<?php


namespace App\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Content
 * @ORM\MappedSuperclass()
 */
abstract class Content
{

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $genre;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $visibility;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Content
     */
    public function setName(string $name): Content
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return Content
     */
    public function setGenre(string $genre): Content
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Content
     */
    public function setDescription(string $description): Content
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Content
     */
    public function setAuthor(string $author): Content
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return Content
     */
    public function setVisibility(string $visibility): Content
    {
        $this->visibility = $visibility;
        return $this;
    }
}