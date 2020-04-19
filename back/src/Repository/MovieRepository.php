<?php

namespace App\Repository;

use App\Entity\Documents\Content;
use App\Entity\Documents\Movie;
use App\Entity\Documents\Serie;
use App\Entity\Security\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class MovieRepository extends ServiceEntityRepository
{
    use AccessiblyCriteriaTrait;

    /** @var Security */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Movie::class);

        $this->security = $security;
    }

    public function getCriteria()
    {
        $criteria = $this->accessibilityCriteria($this->security->getUser());

        return $criteria;
    }
}