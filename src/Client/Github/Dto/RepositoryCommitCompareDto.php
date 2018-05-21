<?php

namespace App\Client\Github\Dto;

class RepositoryCommitCompareDto
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getStatus(): ?string
    {
        return $this->data['status'] ?? null;
    }

    public function getAheadBy(): ?int
    {
        return $this->data['ahead_by'] ?? null;
    }

    public function getBehindBy(): ?int
    {
        return $this->data['behind_by'] ?? null;
    }

    public function getCommits(): ?array
    {
        return $this->data['commits'] ?? null;
    }
}
