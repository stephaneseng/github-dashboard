<?php

namespace App\Command;

use App\Client\GithubClient;
use App\Repository\RepositoryCommitCompareRepository;
use App\Repository\RepositoryRepository;
use Github\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RepositoryCommitCompareFetchCommand extends Command
{
    protected static $defaultName = 'app:repository:commit:compare:fetch';

    /**
     * @var GithubClient
     */
    private $githubClient;

    /**
     * @var RepositoryRepository
     */
    private $repositoryRepository;

    /**
     * @var RepositoryCommitCompareRepository
     */
    private $repositoryCommitCompareRepository;

    /**
     * @param GithubClient $githubClient
     * @throws LogicException
     */
    public function __construct(
        GithubClient $githubClient,
        RepositoryRepository $repositoryRepository,
        RepositoryCommitCompareRepository $repositoryCommitCompareRepository
    )
    {
        parent::__construct(static::$defaultName);
        $this->githubClient = $githubClient;
        $this->repositoryRepository = $repositoryRepository;
        $this->repositoryCommitCompareRepository = $repositoryCommitCompareRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch RepositoryCommitCompare from Github');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->section('Fetching RepositoryCommitCompare');

        $repositories = $this->repositoryRepository->findAll();

        $io->progressStart(count($repositories));
        foreach ($repositories as $repository) {
            $io->text($repository->getFullName());

            try {
                $repositoryCommitCompare = $this->githubClient->fetchRepositoryCommitCompare($repository);
                $this->repositoryCommitCompareRepository->save($repositoryCommitCompare);
            } catch (RuntimeException $e) {
                $io->warning($e->getMessage());
            }

            $io->progressAdvance();
        }
        $io->progressFinish();
    }
}
