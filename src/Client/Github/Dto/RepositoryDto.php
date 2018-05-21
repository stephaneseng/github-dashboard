<?php

namespace App\Client\Github\Dto;

class RepositoryDto
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

    public function getFullName(): ?string
    {
        return $this->data['full_name'] ?? null;
    }

    public function getDefaultBranch(): ?string
    {
        return $this->data['default_branch'] ?? null;
    }

    public function isArchived(): ?bool
    {
        return $this->data['archived'] ?? null;
    }

    public function getCreatedAt(): ?string
    {
        return $this->data['created_at'] ?? null;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->data['updated_at'] ?? null;
    }

    public function getPushedAt(): ?string
    {
        return $this->data['pushed_at'] ?? null;
    }
}
