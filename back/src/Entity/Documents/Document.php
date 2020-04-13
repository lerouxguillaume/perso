<?php

namespace App\Entity\Documents;

use App\Entity\Security\User;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Document
 * @ORM\MappedSuperclass()
 */
abstract class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Exclude()
     * @ORM\Column(type="string", nullable=false)
     */
    private $fileName;

    /**
     * @var string
     * @Exclude()
     * @ORM\Column(type="string", nullable=false)
     */
    private $path;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $private;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     *
     */
    private $owner;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $uploadedAt;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Document
     */
    public function setName(string $name): Document
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return Document
     */
    public function setFileName(string $fileName): Document
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Document
     */
    public function setPath($path): Document
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    /**
     * @param bool $private
     * @return Document
     */
    public function setPrivate(bool $private): Document
    {
        $this->private = $private;
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
     * @return Document
     */
    public function setOwner(User $owner): Document
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt;
    }

    /**
     * @param \DateTime $uploadedAt
     * @return Document
     */
    public function setUploadedAt(\DateTime $uploadedAt): Document
    {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }

    public function getFilePath()
    {
        return $this->getPath().$this->getFileName();
    }
}