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

    public function getId()
    {
        return $this->data['id'];
    }

    public function getFullName()
    {
        return $this->data['full_name'];
    }

    public function getCreatedAt()
    {
        return $this->data['created_at'];
    }

    public function getUpdatedAt()
    {
        return $this->data['updated_at'];
    }

    public function getPushedAt()
    {
        return $this->data['pushed_at'];
    }
}
