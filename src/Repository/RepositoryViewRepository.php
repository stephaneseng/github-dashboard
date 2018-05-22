<?php

namespace App\Repository;

use App\Entity\RepositoryView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RepositoryView|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepositoryView|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepositoryView[]    findAll()
 * @method RepositoryView[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepositoryViewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RepositoryView::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['commitsAheadBy' => 'DESC']);
    }
}
