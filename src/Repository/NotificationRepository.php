<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function findNotificationBy(User $user)
    {
        return $this->createQueryBuilder('n')
            ->select('n', 'u')
            ->leftJoin('n.toUser', 'u')
            ->andWhere('u = :user')
            ->setParameter('user', $user->getId())
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findNotificationNotViewBy(User $user)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->select('n', 'u')
            ->leftJoin('n.toUser', 'u')
            ->andWhere('u = :user')
            // ->andWhere('n.view LIKE :idUser ')
            ->setParameters([
                'user' => $user->getId(),
                // 'idUser' => sprintf('%%,s,%%', $user->getId())
            ])
            ->orderBy('n.id', 'DESC');

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Notification[] Returns an array of Notification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
