<?php

namespace App\Repository;

use App\Entity\Verbatim;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Verbatim>
 *
 * @method Verbatim|null find($id, $lockMode = null, $lockVersion = null)
 * @method Verbatim|null findOneBy(array $criteria, array $orderBy = null)
 * @method Verbatim[]    findAll()
 * @method Verbatim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerbatimRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Verbatim::class);
    }

    public function getTitles(): array
    {
        return $this->createQueryBuilder('v')
            ->select('v.title')
            ->getQuery()
            ->getResult();
    }
}
