<?php

namespace App\DTO;

abstract class ContentDto
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
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
     * @return ContentDto
     */
    public function setName(string $name): ContentDto
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
     * @return ContentDto
     */
    public function setGenre(?string $genre): ContentDto
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
     * @return ContentDto
     */
    public function setDescription(?string $description): ContentDto
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
     * @return ContentDto
     */
    public function setAuthor(?string $author): ContentDto
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVisibility(): bool
    {
        return $this->visibility;
    }

    /**
     * @param bool $visibility
     * @return ContentDto
     */
    public function setVisibility(bool $visibility): ContentDto
    {
        $this->visibility = $visibility;
        return $this;
    }
}