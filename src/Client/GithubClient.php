<?php

namespace App\Client;

use App\Entity\Repository;
use App\Entity\RepositoryCommitCompare;
use Github\Client;
use Github\ResultPager;

class GithubClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     * @param ResultPager $resultPager
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->resultPager = new ResultPager($this->client);
    }

    /**
     * @param string $organizationName
     * @return Repository[]
     */
    public function fetchAllOrganizationRepositories(string $organizationName): array
    {
        $repositoriesResponse = $this->resultPager->fetchAll(
            $this->client->api('organization'),
            'repositories',
            [
                $organizationName
            ]
        );

        $repositories = [];
        foreach ($repositoriesResponse as $repositoryResponse) {
            $repositories[] = new Repository(new RepositoryDto($repositoryResponse));
        }

        return $repositories;
    }

    /**
     * @param Repository $repository
     * @return RepositoryCommitCompare
     */
    public function fetchRepositoryCommitCompare(Repository $repository): RepositoryCommitCompare
    {
        $repositoryCommitCompareResponse = $this->client->api('repo')->commits()->compare(
            explode('/', $repository->getFullName())[0],
            explode('/', $repository->getFullName())[1],
            'master',
            $repository->getDefaultBranch()
        );

        return new RepositoryCommitCompare(
            $repository,
            new RepositoryCommitCompareDto($repositoryCommitCompareResponse)
        );
    }
}
