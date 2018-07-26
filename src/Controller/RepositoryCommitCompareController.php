<?php

namespace App\Controller;

use App\Entity\RepositoryCommitCompare;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RepositoryCommitCompareController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/repositoryCommitCompares/{repositoryId}")
     */
    public function getAction(int $repositoryId)
    {
        $repositoryCommitCompareRepository = $this->em->getRepository(RepositoryCommitCompare::class);
        $repositoryCommitCompare = $repositoryCommitCompareRepository->find($repositoryId);

        return $this->render(
            'RepositoryCommitCompare/get.html.twig',
            [
                'repository_commit_compare' => $repositoryCommitCompare,
            ]
        );
    }
}
