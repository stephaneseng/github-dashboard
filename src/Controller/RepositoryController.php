<?php

namespace App\Controller;

use App\Entity\RepositoryView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RepositoryController extends Controller
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
     * @Route("/")
     */
    public function listAction()
    {
        $repositoryViewRepository = $this->em->getRepository(RepositoryView::class);
        $repositories = $repositoryViewRepository->findAll();

        return $this->render(
            'Repository/list.html.twig',
            [
                'repositories' => $repositories,
            ]
        );
    }
}
