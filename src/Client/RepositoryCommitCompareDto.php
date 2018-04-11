<?php

namespace App\Client;

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
        return $this->data['status'];
    }

    public function getAheadBy(): ?int
    {
        return $this->data['ahead_by'];
    }
}
