<?php

namespace App\Client\Github;

use App\Client\Github\Dto\RepositoryDto;
use App\Entity\Repository;
use Github\Api\AbstractApi;
use Github\Api\Organization;
use Github\Api\PullRequest;
use Github\Api\Repo;
use Github\Api\Repository\Commits;
use Github\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Cache\CacheItemPoolInterface;

class GithubClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFetchAllOrganizationRepositories()
    {
        $id = 1;
        $fullName = 'organizationName/repositoryName';
        $defaultBranch = 'defaultBranch';
        $archived = false;
        $createdAt = '2018-01-01T00:00Z';
        $updatedAt = '2018-01-02T00:00Z';
        $pushedAt = '2018-01-03T00:00Z';

        // Given.
        $organizationsApiClient = $this->anOrganizationsApiClient(
            'organizationName',
            [
                [
                    'id' => $id,
                    'full_name' => $fullName,
                    'default_branch' => $defaultBranch,
                    'archived' => $archived,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'pushed_at' => $pushedAt,
                ],
            ]
        );
        $apiClient = $this->anApiClient('organizations', $organizationsApiClient->reveal());
        $githubClient = new GithubClient($apiClient->reveal());

        // When.
        $repositories = $githubClient->fetchAllOrganizationRepositories('organizationName');

        // Then.
        $repository = $repositories[0];
        $this->assertEquals($id, $repository->getId());
        $this->assertEquals($fullName, $repository->getFullName());
        $this->assertEquals($defaultBranch, $repository->getDefaultBranch());
        $this->assertEquals($archived, $repository->isArchived());
        $this->assertEquals(new \DateTime($createdAt), $repository->getCreatedAt());
        $this->assertEquals(new \DateTime($updatedAt), $repository->getUpdatedAt());
        $this->assertEquals(new \DateTime($pushedAt), $repository->getPushedAt());
    }

    /**
     * @test
     */
    public function shouldFetchRepositoryCommitCompare()
    {
        $status = 'status';
        $aheadBy = 1;
        $behindBy = 2;
        $commits = [];

        // Given.
        $commitsApiClient = $this->aCommitsApiClient(
            'organizationName',
            'repositoryName',
            GithubClient::BASE_BRANCH,
            [
                'status' => $status,
                'ahead_by' => $aheadBy,
                'behind_by' => $behindBy,
                'commits' => $commits,
            ]
        );
        $repositoriesApiClient = $this->aRepositoriesApiClient('commits', $commitsApiClient->reveal());
        $apiClient = $this->anApiClient('repositories', $repositoriesApiClient->reveal());
        $githubClient = new GithubClient($apiClient->reveal());

        // When.
        $repositoryCommitCompare = $githubClient->fetchRepositoryCommitCompare($this->aRepository('organizationName/repositoryName'));

        // Then.
        $this->assertEquals($status, $repositoryCommitCompare->getStatus());
        $this->assertEquals($aheadBy, $repositoryCommitCompare->getAheadBy());
        $this->assertEquals($behindBy, $repositoryCommitCompare->getBehindBy());
        $this->assertEquals($commits, $repositoryCommitCompare->getCommits());
    }

    /**
     * @test
     */
    public function shouldFetchAllPullRequests()
    {
        $id = 1;
        $state = 'state';
        $title = 'title';
        $userLogin = 'userLogin';
        $createdAt = '2018-01-01T00:00Z';
        $updatedAt = '2018-01-02T00:00Z';
        $closedAt = '2018-01-03T00:00Z';
        $mergedAt = '2018-01-04T00:00Z';

        // Given.
        $pullRequestsApiClient = $this->aPullRequestsApiClient(
            'organizationName',
            'repositoryName',
            [
                [
                    'id' => $id,
                    'state' => $state,
                    'title' => $title,
                    'user' => [
                        'login' => $userLogin,
                    ],
                    'createdAt' => $createdAt,
                    'updatedAt' => $updatedAt,
                    'closedAt' => $closedAt,
                    'mergedAt' => $mergedAt,
                ],
            ]
        );
        $apiClient = $this->anApiClient('pull_requests', $pullRequestsApiClient->reveal());
        $githubClient = new GithubClient($apiClient->reveal());

        // When.
        $pullRequests = $githubClient->fetchAllPullRequests($this->aRepository('organizationName/repositoryName'));

        // Then.
        $pullRequest = $pullRequests[0];
        $this->assertEquals($id, $pullRequest->getId());
    }

    /**
     * @param string $fullName
     * @return Repository
     */
    private function aRepository(string $fullName): Repository
    {
        $repository = new Repository();
        $repository->setFullName($fullName);

        return $repository;
    }

    /**
     * @param string $organizationName
     * @param array $data
     * @return ObjectProphecy
     */
    private function anOrganizationsApiClient(string $organizationName, array $data): ObjectProphecy
    {
        $organizationsApiClient = $this->prophesize(Organization::class);

        $organizationsApiClient->getPerPage()
            ->willReturn(100);
        $organizationsApiClient->setPerPage(Argument::type('integer'))
            ->shouldBeCalled();

        $organizationsApiClient->repositories($organizationName)
            ->willReturn($data);

        return $organizationsApiClient;
    }

    /**
     * @param string $organizationName
     * @param string $repositoryName
     * @param string $defaultBranch
     * @param array $data
     * @return ObjectProphecy
     */
    private function aCommitsApiClient(
        string $organizationName,
        string $repositoryName,
        string $defaultBranch,
        array $data
    ): ObjectProphecy
    {
        $commitsApiClient = $this->prophesize(Commits::class);

        $commitsApiClient->compare($organizationName, $repositoryName, $defaultBranch, null)
            ->willReturn($data);

        return $commitsApiClient;
    }

    /**
     * @param string $apiName
     * @param AbstractApi $api
     * @return ObjectProphecy
     */
    private function aRepositoriesApiClient(string $apiName, AbstractApi $api): ObjectProphecy
    {
        $repositoriesApiClient = $this->prophesize(Repo::class);

        $repositoriesApiClient->{$apiName}()
            ->willReturn($api);

        return $repositoriesApiClient;
    }

    /**
     * @param string $organizationName
     * @param string $repositoryName
     * @param array $data
     * @return ObjectProphecy
     */
    private function aPullRequestsApiClient(
        string $organizationName,
        string $repositoryName,
        array $data
    ): ObjectProphecy
    {
        $pullRequestsApiClient = $this->prophesize(PullRequest::class);

        $pullRequestsApiClient->getPerPage()
            ->willReturn(100);
        $pullRequestsApiClient->setPerPage(Argument::type('integer'))
            ->shouldBeCalled();

        $pullRequestsApiClient->all($organizationName, $repositoryName)
            ->willReturn($data);

        return $pullRequestsApiClient;
    }

    /**
     * @param string $apiName
     * @param AbstractApi $api
     * @return ObjectProphecy
     */
    private function anApiClient(string $apiName, AbstractApi $api): ObjectProphecy
    {
        $apiClient = $this->prophesize(Client::class);

        $apiClient->api($apiName)
            ->willReturn($api);

        $apiClient->addCache(Argument::type(CacheItemPoolInterface::class))
            ->shouldBeCalled();
        $apiClient->getLastResponse()
            ->willReturn(new Response());

        return $apiClient;
    }
}
