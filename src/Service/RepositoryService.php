<?php

namespace App\Service;

use App\Entity\Repository;
use App\Repository\RepositoryRepository;

class RepositoryService
{
    /**
     * @var RepositoryRepository
     */
    private $repositoryRepository;

    /**
     * @param RepositoryRepository $repositoryRepository
     */
    public function __construct(RepositoryRepository $repositoryRepository)
    {
        $this->repositoryRepository = $repositoryRepository;
    }

    /**
     * @param Repository $repository
     */
    public function save(Repository $repository)
    {
        if ($this->repositoryRepository->find($repository->getId())) {
            $this->repositoryRepository->merge($repository);
        } else {
            $this->repositoryRepository->persist($repository);
        }
    }
}
