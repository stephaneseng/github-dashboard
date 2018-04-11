<?php

namespace App\Repository;

use App\Entity\RepositoryCommitCompare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RepositoryCommitCompare|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepositoryCommitCompare|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepositoryCommitCompare[]    findAll()
 * @method RepositoryCommitCompare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepositoryCommitCompareRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RepositoryCommitCompare::class);
    }

    /**
     * @param RepositoryCommitCompare $repositoryCommitCompare
     */
    public function save(RepositoryCommitCompare $repositoryCommitCompare)
    {
        if ($this->find($repositoryCommitCompare->getRepository()->getId())) {
            $this->_em->merge($repositoryCommitCompare);
        } else {
            $this->_em->persist($repositoryCommitCompare);
        }

        $this->_em->flush();
    }
}
