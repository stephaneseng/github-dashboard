<?php

namespace App\Controller;

use App\Entity\PullRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PullRequestController extends Controller
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
     * @Route("/pullRequests")
     */
    public function listAction(Request $request)
    {
        $pullRequestRepository = $this->em->getRepository(PullRequest::class);
        $pullRequests = $pullRequestRepository->findBy([
            'repository' => $request->query->get('repositoryId'),
        ]);

        return $this->render(
            'PullRequest/list.html.twig',
            [
                'pull_requests' => $pullRequests,
            ]
        );
    }
}
