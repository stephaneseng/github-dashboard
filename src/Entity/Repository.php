<?php

namespace App\Entity;

use App\Client\RepositoryDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepositoryRepository")
 */
class Repository
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $defaultBranch;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $pushedAt;

    /**
     * @param RepositoryDto $repositoryDto
     */
    public function __construct(RepositoryDto $repositoryDto)
    {
        $this->id = $repositoryDto->getId();
        $this->fullName = $repositoryDto->getFullName();
        $this->defaultBranch = $repositoryDto->getDefaultBranch();
        $this->archived = $repositoryDto->isArchived();
        $this->createdAt = new \DateTime($repositoryDto->getCreatedAt());
        $this->updatedAt = new \DateTime($repositoryDto->getUpdatedAt());
        $this->pushedAt = new \DateTime($repositoryDto->getPushedAt());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDefaultBranch(): ?string
    {
        return $this->defaultBranch;
    }

    public function setDefaultBranch(string $defaultBranch): self
    {
        $this->fullName = $defaultBranch;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPushedAt(): ?\DateTimeInterface
    {
        return $this->pushedAt;
    }

    public function setPushedAt(\DateTimeInterface $pushedAt): self
    {
        $this->pushedAt = $pushedAt;

        return $this;
    }
}
