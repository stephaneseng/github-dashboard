<?php

namespace App\Client;

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
        return $this->data['id'];
    }

    public function getState(): ?string
    {
        return $this->data['state'];
    }

    public function getTitle(): ?string
    {
        return $this->data['title'];
    }

    public function getUserLogin(): ?string
    {
        return $this->data['user']['login'];
    }

    public function getCreatedAt(): ?string
    {
        return $this->data['created_at'];
    }

    public function getUpdatedAt(): ?string
    {
        return $this->data['updated_at'];
    }

    public function getClosedAt(): ?string
    {
        return $this->data['closed_at'];
    }

    public function getMergedAt(): ?string
    {
        return $this->data['merged_at'];
    }
}
