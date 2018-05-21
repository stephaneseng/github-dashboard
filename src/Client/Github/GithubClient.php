<?php

namespace App\Client\Github;

use App\Client\Github\Dto\PullRequestDto;
use App\Client\Github\Dto\RepositoryCommitCompareDto;
use App\Client\Github\Dto\RepositoryDto;
use App\Entity\PullRequest;
use App\Entity\Repository;
use App\Entity\RepositoryCommitCompare;
use Github\Client;
use Github\ResultPager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class GithubClient
{
    const BASE_BRANCH = 'master';

    /**
     * @var Client
     */
    private $apiClient;

    /**
     * @param Client $apiClient
     * @param ResultPager $resultPager
     */
    public function __construct(Client $apiClient)
    {
        $this->apiClient = $apiClient;
        $this->resultPager = new ResultPager($this->apiClient);

        $this->apiClient->addCache(new FilesystemAdapter());
    }

    /**
     * @param string $organizationName
     * @return Repository[]
     */
    public function fetchAllOrganizationRepositories(string $organizationName): array
    {
        $repositoriesResponse = $this->resultPager->fetchAll(
            $this->apiClient->api('organizations'),
            'repositories',
            [
                $organizationName,
            ]
        );

        $repositories = [];
        foreach ($repositoriesResponse as $repositoryResponse) {
            $repositories[] = (new Repository())->apply(
                new RepositoryDto($repositoryResponse)
            );
        }

        return $repositories;
    }

    /**
     * @param Repository $repository
     * @return RepositoryCommitCompare
     */
    public function fetchRepositoryCommitCompare(Repository $repository): RepositoryCommitCompare
    {
        $repositoryFullNameParts = explode('/', $repository->getFullName());

        $repositoryCommitCompareResponse = $this->apiClient->api('repositories')->commits()->compare(
            $repositoryFullNameParts[0],
            $repositoryFullNameParts[1],
            self::BASE_BRANCH,
            $repository->getDefaultBranch()
        );

        return (new RepositoryCommitCompare())->apply(
            $repository,
            new RepositoryCommitCompareDto($repositoryCommitCompareResponse)
        );
    }

    /**
     * @param Repository $repository
     * @return PullRequest[]
     */
    public function fetchAllPullRequests(Repository $repository): array
    {
        $repositoryFullNameParts = explode('/', $repository->getFullName());

        $pullRequestsResponse = $this->resultPager->fetchAll(
            $this->apiClient->api('pull_requests'),
            'all',
            [
                $repositoryFullNameParts[0],
                $repositoryFullNameParts[1],
            ]
        );

        $pullRequests = [];
        foreach ($pullRequestsResponse as $pullRequestResponse) {
            $pullRequests[] = (new PullRequest())->apply(
                $repository,
                new PullRequestDto($pullRequestResponse)
            );
        }

        return $pullRequests;
    }
}
