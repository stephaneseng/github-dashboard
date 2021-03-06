<?php

namespace App\Entity;

use App\Client\Github\Dto\RepositoryCommitCompareDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepositoryCommitCompareRepository")
 */
class RepositoryCommitCompare
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Repository")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $aheadBy;

    /**
     * @ORM\Column(type="integer")
     */
    private $behindBy;

    /**
     * @ORM\Column(type="json")
     */
    private $commits;

    /**
     * @param Repository $repository
     * @param RepositoryCommitCompareDto $repositoryCommitCompareDto
     * @return RepositoryCommitCompare
     */
    public function apply(
        Repository $repository,
        RepositoryCommitCompareDto $repositoryCommitCompareDto
    ): self
    {
        $this->repository = $repository;
        $this->status = $repositoryCommitCompareDto->getStatus();
        $this->aheadBy = $repositoryCommitCompareDto->getAheadBy();
        $this->behindBy = $repositoryCommitCompareDto->getBehindBy();
        $this->commits = $repositoryCommitCompareDto->getCommits();

        return $this;
    }

    public function getRepository(): ?Repository
    {
        return $this->repository;
    }

    public function setRepository(Repository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAheadBy(): ?int
    {
        return $this->aheadBy;
    }

    public function setAheadBy(int $aheadBy): self
    {
        $this->aheadBy = $aheadBy;

        return $this;
    }

    public function getBehindBy(): ?int
    {
        return $this->behindBy;
    }

    public function setBehindBy(int $behindBy): self
    {
        $this->behindBy = $behindBy;

        return $this;
    }

    public function getCommits(): ?array
    {
        return $this->commits;
    }

    public function setCommits(array $commits): self
    {
        $this->commits = $commits;

        return $this;
    }
}
