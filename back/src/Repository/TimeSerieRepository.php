<?php

namespace App\Repository;

use App\Entity\Entreprise;
use App\Entity\TimeSerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TimeSerieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TimeSerie::class);
    }

    /**
     * @param Entreprise $entreprise
     * @param $timestamp
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findClosestTimeSerie(Entreprise $entreprise, $timestamp)
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp <= :timestamp')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('timestamp', $timestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return current($qb->execute());
    }

    /**
     * @param Entreprise $entreprise
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastTimeSerieTimestamp(Entreprise $entreprise)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('MAX(t.timestamp)')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('entreprise', $entreprise->getId())
            ->getQuery();

        return $qb->getSingleScalarResult();
    }

    /**
     * @param Entreprise $entreprise
     * @return mixed
     */
    public function findLastWeekTimeSerie(Entreprise $entreprise)
    {
        $weekAgoTimestamp = strtotime('-7 day midnight');

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp >= :weekAgo')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('weekAgo', $weekAgoTimestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param Entreprise $entreprise
     * @return mixed
     */
    public function findLastMonthTimeSerie(Entreprise $entreprise)
    {
        $monthAgoTimestamp = strtotime('-1 month midnight');

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp >= :monthAgo')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('monthAgo', $monthAgoTimestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param Entreprise $entreprise
     * @return mixed
     */
    public function findLastYearTimeSerie(Entreprise $entreprise)
    {
        $yearAgoTimestamp = strtotime('-1 year midnight');
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp >= :yearAgo')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('yearAgo', $yearAgoTimestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'ASC')
            ->getQuery();

        return $qb->execute();
    }
}