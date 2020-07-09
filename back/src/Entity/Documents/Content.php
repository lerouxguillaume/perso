<?php


namespace App\Entity\Documents;

use App\Entity\Security\User;
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $visibility;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     *
     */
    private $owner;

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
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return Content
     */
    public function setGenre(?string $genre): Content
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Content
     */
    public function setDescription(?string $description): Content
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Content
     */
    public function setAuthor(?string $author): Content
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVisibility(): bool
    {
        return $this->visibility ?? false;
    }

    /**
     * @param bool $visibility
     * @return bool
     */
    public function setVisibility(bool $visibility): Content
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return User
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return Content
     */
    public function setOwner(User $owner): Content
    {
        $this->owner = $owner;
        return $this;
    }
}