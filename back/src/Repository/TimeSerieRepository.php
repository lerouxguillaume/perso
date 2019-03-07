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

    public function findLastMonthTimeSerie(Entreprise $entreprise)
    {
        $weekAgoTimestamp = strtotime('-1 month day midnight');

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp >= :weekAgo')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('weekAgo', $weekAgoTimestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    public function findLastYearTimeSerie(Entreprise $entreprise)
    {
        $weekAgoTimestamp = strtotime('-1 year day midnight');

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.timestamp >= :weekAgo')
            ->andWhere('t.entreprise = :entreprise')
            ->setParameter('weekAgo', $weekAgoTimestamp)
            ->setParameter('entreprise', $entreprise->getId())
            ->orderBy('t.timestamp', 'ASC')
            ->getQuery();

        return $qb->execute();
    }
}