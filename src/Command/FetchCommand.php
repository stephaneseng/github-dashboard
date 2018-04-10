<?php

namespace App\Command;

use App\Client\GithubClient;
use App\Service\RepositoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FetchCommand extends Command
{
    protected static $defaultName = 'app:fetch';

    /**
     * @var GithubClient
     */
    private $githubClient;

    /**
     * @var RepositoryService
     */
    private $repositoryService;

    /**
     * @param GithubClient $githubClient
     * @throws LogicException
     */
    public function __construct(GithubClient $githubClient, RepositoryService $repositoryService)
    {
        parent::__construct(static::$defaultName);
        $this->githubClient = $githubClient;
        $this->repositoryService = $repositoryService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch data from Github')
            ->addArgument('organizationName', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $organizationName = $input->getArgument('organizationName');

        $repositories = $this->githubClient->fetchAllOrganizationRepositories($organizationName);

        $io->section('Fetching Repositories');
        $io->progressStart(count($repositories));
        foreach ($repositories as $repository) {
            $this->repositoryService->save($repository);
            $io->progressAdvance();
        }
        $io->progressFinish();

        $io->section('Fetching Pull Requests');

        $io->success('OK');
    }
}
