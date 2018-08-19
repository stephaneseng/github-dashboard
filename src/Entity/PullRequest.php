<?php

namespace App\Entity;

use App\Client\Github\Dto\PullRequestDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PullRequestRepository")
 */
class PullRequest
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Repository")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $htmlUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userLogin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $mergedAt;

    /**
     * @param Repository $repository
     * @param PullRequestDto $pullRequestDto
     * @return PullRequest
     */
    public function apply(
        Repository $repository,
        PullRequestDto $pullRequestDto
    ): self
    {
        $this->id = $pullRequestDto->getId();
        $this->repository = $repository;
        $this->htmlUrl = $pullRequestDto->getHtmlUrl();
        $this->state = $pullRequestDto->getState();
        $this->title = $pullRequestDto->getTitle();
        $this->userLogin = $pullRequestDto->getUserLogin();
        $this->createdAt = new \DateTime($pullRequestDto->getCreatedAt());
        $this->updatedAt = new \DateTime($pullRequestDto->getUpdatedAt());
        $this->closedAt = ($pullRequestDto->getClosedAt() === null) ? null : new \DateTime(
            $pullRequestDto->getClosedAt()
        );
        $this->mergedAt = ($pullRequestDto->getMergedAt() === null) ? null : new \DateTime(
            $pullRequestDto->getMergedAt()
        );

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRepository(): ?Repository
    {
        return $this->repository;
    }

    public function setRepository(?Repository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getHtmlUrl(): ?string
    {
        return $this->htmlUrl;
    }

    public function setHtmlUrl(string $htmlUrl): self
    {
        $this->htmlUrl = $htmlUrl;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUserLogin(): ?string
    {
        return $this->userLogin;
    }

    public function setUserLogin(string $userLogin): self
    {
        $this->userLogin = $userLogin;

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

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTimeInterface $closedAt): self
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    public function getMergedAt(): ?\DateTimeInterface
    {
        return $this->mergedAt;
    }

    public function setMergedAt(?\DateTimeInterface $mergedAt): self
    {
        $this->mergedAt = $mergedAt;

        return $this;
    }
}
