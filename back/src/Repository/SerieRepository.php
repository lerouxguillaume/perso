<?php

namespace App\Repository;

use App\Entity\Documents\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class SerieRepository extends ServiceEntityRepository
{
    use AccessiblyCriteriaTrait;

    /** @var Security */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Serie::class);

        $this->security = $security;
    }

    public function getCriteria()
    {
        $criteria = $this->accessibilityCriteria($this->security->getUser());

        return $criteria;
    }
}