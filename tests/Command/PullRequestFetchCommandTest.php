<?php

namespace App\Command;

use App\Client\Github\GithubClient;
use App\Entity\PullRequest;
use App\Entity\Repository;
use App\Repository\PullRequestRepository;
use App\Repository\RepositoryRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class PullRequestFetchCommandTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExecute()
    {
        $repository = $this->aRepository('organizationName/repositoryName');
        $pullRequest = $this->aPullRequest();

        // Given.
        $repositoryRepository = $this->aRepositoryRepository([$repository]);
        $githubClient = $this->aGithubClient($repository, [$pullRequest]);
        $pullRequestRepository = $this->aPullRequestRepository([$pullRequest]);
        $pullRequestFetchCommand = new PullRequestFetchCommand(
            $githubClient->reveal(),
            $repositoryRepository->reveal(),
            $pullRequestRepository->reveal()
        );

        // When.
        $exitCode = $pullRequestFetchCommand->run(
            new ArrayInput([]),
            new NullOutput()
        );

        // Then.
        $this->assertEquals(0, $exitCode);
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
     * @return PullRequest
     */
    private function aPullRequest(): PullRequest
    {
        return new PullRequest();
    }

    /**
     * @return ObjectProphecy
     */
    private function aPullRequestRepository(array $pullRequests): ObjectProphecy
    {
        $pullRequestRepository = $this->prophesize(PullRequestRepository::class);

        $pullRequestRepository->saveAll($pullRequests)
            ->shouldBeCalled();

        return $pullRequestRepository;
    }

    /**
     * @param string $organizationName
     * @param array $data
     * @return ObjectProphecy
     */
    private function aGithubClient(Repository $repository, array $data): ObjectProphecy
    {
        $githubClient = $this->prophesize(GithubClient::class);

        $githubClient->fetchAllPullRequests($repository)
            ->willReturn($data);

        return $githubClient;
    }

    /**
     * @param array $repositories
     * @return ObjectProphecy
     */
    private function aRepositoryRepository(array $repositories): ObjectProphecy
    {
        $repositoryRepository = $this->prophesize(RepositoryRepository::class);

        $repositoryRepository->findAll()
            ->willReturn($repositories);

        return $repositoryRepository;
    }
}
