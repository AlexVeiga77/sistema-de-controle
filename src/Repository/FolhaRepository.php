<?php

namespace App\Repository;

use App\Entity\Folha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Folha|null find($id, $lockMode = null, $lockVersion = null)
 * @method Folha|null findOneBy(array $criteria, array $orderBy = null)
 * @method Folha[]    findAll()
 * @method Folha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FolhaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Folha::class);
    }

//    /**
//     * @return Folha[] Returns an array of Folha objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Folha
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
