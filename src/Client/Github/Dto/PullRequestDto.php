<?php

namespace App\Client\Github\Dto;

class PullRequestDto
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

    public function getId(): ?int
    {
        return $this->data['id'] ?? null;
    }

    public function getState(): ?string
    {
        return $this->data['state'] ?? null;
    }

    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function getUserLogin(): ?string
    {
        return $this->data['user']['login'] ?? null;
    }

    public function getCreatedAt(): ?string
    {
        return $this->data['created_at'] ?? null;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->data['updated_at'] ?? null;
    }

    public function getClosedAt(): ?string
    {
        return $this->data['closed_at'] ?? null;
    }

    public function getMergedAt(): ?string
    {
        return $this->data['merged_at'] ?? null;
    }
}
