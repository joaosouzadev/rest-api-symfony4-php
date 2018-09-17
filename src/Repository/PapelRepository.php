<?php

namespace App\Repository;

use App\Entity\Papel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Papel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Papel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Papel[]    findAll()
 * @method Papel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PapelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Papel::class);
    }

//    /**
//     * @return Papel[] Returns an array of Papel objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Papel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
