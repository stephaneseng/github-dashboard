<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepositoryViewRepository")
 */
class RepositoryView
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
     * @ORM\Column(type="datetime")
     */
    private $pushedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $commitsAheadBy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $openedPullRequests;

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

    public function getPushedAt(): ?\DateTimeInterface
    {
        return $this->pushedAt;
    }

    public function setPushedAt(\DateTimeInterface $pushedAt): self
    {
        $this->pushedAt = $pushedAt;

        return $this;
    }

    public function getCommitsAheadBy(): ?int
    {
        return $this->commitsAheadBy;
    }

    public function setCommitsAheadBy(int $commitsAheadBy): self
    {
        $this->commitsAheadBy = $commitsAheadBy;

        return $this;
    }

    public function getOpenedPullRequests(): ?int
    {
        return $this->openedPullRequests;
    }

    public function setOpenedPullRequests(?int $openedPullRequests): self
    {
        $this->openedPullRequests = $openedPullRequests;

        return $this;
    }
}
