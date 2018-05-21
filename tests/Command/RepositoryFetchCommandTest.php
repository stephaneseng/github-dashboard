<?php

namespace App\Command;

use App\Client\Github\GithubClient;
use App\Entity\Repository;
use App\Repository\RepositoryRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class RepositoryFetchCommandTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExecute()
    {
        $repository = $this->aRepository('organizationName/repositoryName');

        // Given.
        $githubClient = $this->aGithubClient('organizationName', [$repository]);
        $repositoryRepository = $this->aRepositoryRepository($repository);
        $repositoryFetchCommand = new RepositoryFetchCommand($githubClient->reveal(), $repositoryRepository->reveal());

        // When.
        $exitCode = $repositoryFetchCommand->run(
            new ArrayInput(
                [
                    'organizationName' => 'organizationName',
                ]
            ),
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
     * @param string $organizationName
     * @param array $data
     * @return ObjectProphecy
     */
    private function aGithubClient(string $organizationName, array $data): ObjectProphecy
    {
        $githubClient = $this->prophesize(GithubClient::class);

        $githubClient->fetchAllOrganizationRepositories($organizationName)
            ->willReturn($data);

        return $githubClient;
    }

    /**
     * @param Repository $repository
     * @return ObjectProphecy
     */
    private function aRepositoryRepository(Repository $repository): ObjectProphecy
    {
        $repositoryRepository = $this->prophesize(RepositoryRepository::class);

        $repositoryRepository->save($repository)
            ->shouldBeCalled();

        return $repositoryRepository;
    }
}
