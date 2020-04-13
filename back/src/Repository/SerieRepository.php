<?php

namespace App\Repository;

use App\Entity\Documents\Content;
use App\Entity\Documents\Serie;
use App\Entity\Security\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $params
     * @return mixed
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findAllSeries(?User $user, $params = null, $offset = null, $limit = null)
    {
        $criteria = Criteria::create();
        $criteria
            ->where($criteria->expr()->eq('visibility',true))
        ;

        if (!empty($user)) {
            $criteria->orWhere($criteria->expr()->eq('visibility',false))
                ->andWhere($criteria->expr()->eq('owner', $user))
            ;
        }

        $qb = $this->createQueryBuilder('q')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->from(Serie::class, 's')
            ->addCriteria($criteria)
            ->getQuery();

        return new Paginator($qb);
    }
}