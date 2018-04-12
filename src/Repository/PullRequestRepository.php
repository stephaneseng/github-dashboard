<?php

namespace App\Repository;

use App\Entity\PullRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PullRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method PullRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method PullRequest[]    findAll()
 * @method PullRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PullRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PullRequest::class);
    }

    /**
     * @param PullRequest $pullRequest
     */
    public function save(PullRequest $pullRequest)
    {
        if ($this->find($pullRequest->getId())) {
            $this->_em->merge($pullRequest);
        } else {
            $this->_em->persist($pullRequest);
        }

        $this->_em->flush();
    }

    /**
     * @param PullRequest[] $pullRequests
     */
    public function saveAll(array $pullRequests)
    {
        foreach ($pullRequests as $pullRequest) {
            $this->save($pullRequest);
        }
    }
}
