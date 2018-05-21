<?php

namespace App\Command;

use App\Client\Github\GithubClient;
use App\Entity\Repository;
use App\Entity\RepositoryCommitCompare;
use App\Repository\RepositoryCommitCompareRepository;
use App\Repository\RepositoryRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class RepositoryCommitCompareFetchCommandTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExecute()
    {
        $repository = $this->aRepository('organizationName/repositoryName');
        $repositoryCommitCompare = $this->aRepositoryCommitCompare();

        // Given.
        $repositoryRepository = $this->aRepositoryRepository([$repository]);
        $githubClient = $this->aGithubClient($repository, $repositoryCommitCompare);
        $repositoryCommitCompareRepository = $this->aRepositoryCommitCompareRepository($repositoryCommitCompare);
        $repositoryCommitCompareFetchCommand = new RepositoryCommitCompareFetchCommand(
            $githubClient->reveal(),
            $repositoryRepository->reveal(),
            $repositoryCommitCompareRepository->reveal()
        );

        // When.
        $exitCode = $repositoryCommitCompareFetchCommand->run(
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
     * @return RepositoryCommitCompare
     */
    private function aRepositoryCommitCompare(): RepositoryCommitCompare
    {
        return new RepositoryCommitCompare();
    }

    /**
     * @return ObjectProphecy
     */
    private function aRepositoryCommitCompareRepository(RepositoryCommitCompare $repositoryCommitCompare): ObjectProphecy
    {
        $repositoryCommitCompareRepository = $this->prophesize(RepositoryCommitCompareRepository::class);

        $repositoryCommitCompareRepository->save($repositoryCommitCompare)
            ->shouldBeCalled();

        return $repositoryCommitCompareRepository;
    }

    /**
     * @param string $organizationName
     * @param array $data
     * @return ObjectProphecy
     */
    private function aGithubClient(Repository $repository, RepositoryCommitCompare $data): ObjectProphecy
    {
        $githubClient = $this->prophesize(GithubClient::class);

        $githubClient->fetchRepositoryCommitCompare($repository)
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
