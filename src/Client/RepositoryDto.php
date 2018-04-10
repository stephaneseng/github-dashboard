<?php

namespace App\Client;

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
        return $this->data['id'];
    }

    public function getFullName(): ?string
    {
        return $this->data['full_name'];
    }

    public function getDefaultBranch(): ?string
    {
        return $this->data['default_branch'];
    }

    public function isArchived(): ?bool
    {
        return $this->data['archived'];
    }

    public function getCreatedAt(): ?string
    {
        return $this->data['created_at'];
    }

    public function getUpdatedAt(): ?string
    {
        return $this->data['updated_at'];
    }

    public function getPushedAt(): ?string
    {
        return $this->data['pushed_at'];
    }
}
