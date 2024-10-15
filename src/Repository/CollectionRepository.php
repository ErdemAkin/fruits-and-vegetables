<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CollectionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionEntity[] findAll()
 * @method CollectionEntity[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionEntity::class);
    }
}
