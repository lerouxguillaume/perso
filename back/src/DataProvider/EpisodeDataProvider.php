<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\DataProvider\Hydrator\EpisodeHydrator;
use App\DataProvider\Hydrator\SerieHydrator;
use App\DTO\EpisodeDto;
use App\DTO\SerieDto;
use App\Entity\Documents\Episode;
use App\Entity\Documents\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class EpisodeDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var EpisodeHydrator  */
    private $episodeHydrator;
    /** @var Security */
    private $security;

    /**
     * SerieDataProvider constructor.
     * @param EntityManagerInterface $em
     * @param EpisodeHydrator $episodeHydrator $episodeHydrator
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $em,
        EpisodeHydrator $episodeHydrator,
        Security $security
    ) {
        $this->em = $em;
        $this->episodeHydrator = $episodeHydrator;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        //@TODO: implement video url with token
        /** @var Episode $episode */
        $episode = $this->em->getRepository(Episode::class)->find($id);
        return !empty($episode) ? $this->episodeHydrator->hydrate($episode) : null;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === EpisodeDto::class;
    }
}