<?php

namespace App\Command;

use App\Client\GithubClient;
use App\Repository\RepositoryRepository;
use Github\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RepositoryFetchCommand extends Command
{
    protected static $defaultName = 'app:repository:fetch';

    /**
     * @var GithubClient
     */
    private $githubClient;

    /**
     * @var RepositoryRepository
     */
    private $repositoryRepository;

    /**
     * @param GithubClient $githubClient
     * @throws LogicException
     */
    public function __construct(GithubClient $githubClient, RepositoryRepository $repositoryRepository)
    {
        parent::__construct(static::$defaultName);
        $this->githubClient = $githubClient;
        $this->repositoryRepository = $repositoryRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch Repository from Github')
            ->addArgument('organizationName', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $organizationName = $input->getArgument('organizationName');

        $io->section('Fetching Repository');

        try {
            $repositories = $this->githubClient->fetchAllOrganizationRepositories($organizationName);
        } catch (RuntimeException $e) {
            $io->error($e->getMessage());
            return 1;
        }

        $io->progressStart(count($repositories));
        foreach ($repositories as $repository) {
            $io->text($repository->getFullName());

            $this->repositoryRepository->save($repository);

            $io->progressAdvance();
        }
        $io->progressFinish();
    }
}
