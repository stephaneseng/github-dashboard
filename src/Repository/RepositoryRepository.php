<?php

namespace App\Repository;

use App\Entity\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Repository|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repository|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repository[]    findAll()
 * @method Repository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepositoryRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Repository::class);
    }

    /**
     * @param Repository $repository
     */
    public function save(Repository $repository)
    {
        if ($this->find($repository->getId())) {
            $this->_em->merge($repository);
        } else {
            $this->_em->persist($repository);
        }

        $this->_em->flush();
    }
}
