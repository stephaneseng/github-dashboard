<?php

namespace App\Controller;

use App\Entity\RepositoryView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
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
    public function indexAction()
    {
        $repositoryViewRepository = $this->em->getRepository(RepositoryView::class);
        $repositories = $repositoryViewRepository->findAll();

        return $this->render(
            'index.html.twig',
            [
                'repositories' => $repositories,
            ]
        );
    }
}
