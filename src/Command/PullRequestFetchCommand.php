<?php

namespace App\Command;

use App\Client\GithubClient;
use App\Repository\PullRequestRepository;
use App\Repository\RepositoryRepository;
use Github\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullRequestFetchCommand extends Command
{
    protected static $defaultName = 'app:pull-request:fetch';

    /**
     * @var GithubClient
     */
    private $githubClient;

    /**
     * @var RepositoryRepository
     */
    private $repositoryRepository;

    /**
     * @var PullRequestRepository
     */
    private $pullRequestRepository;

    /**
     * @param GithubClient $githubClient
     * @throws LogicException
     */
    public function __construct(
        GithubClient $githubClient,
        RepositoryRepository $repositoryRepository,
        PullRequestRepository $pullRequestRepository
    )
    {
        parent::__construct(static::$defaultName);
        $this->githubClient = $githubClient;
        $this->repositoryRepository = $repositoryRepository;
        $this->pullRequestRepository = $pullRequestRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch PullRequest from Github');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->section('Fetching PullRequest');

        $repositories = $this->repositoryRepository->findAll();

        $io->progressStart(count($repositories));
        foreach ($repositories as $repository) {
            $io->text($repository->getFullName());

            try {
                $pullRequests = $this->githubClient->fetchAllPullRequests($repository);
                $this->pullRequestRepository->saveAll($pullRequests);
            } catch (RuntimeException $e) {
                $io->warning($e->getMessage());
            }

            $io->progressAdvance();
        }
        $io->progressFinish();
    }
}
