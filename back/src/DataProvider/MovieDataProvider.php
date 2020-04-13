<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Controller\MovieDto;
use App\DataProvider\Hydrator\MovieHydrator;
use App\Entity\Documents\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;

class MovieDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var MovieHydrator  */
    private $movieHydrator;
    /** @var RequestStack */
    private $requestStack;
    /** @var Security */
    private $security;

    /**
     * SerieDataProvider constructor.
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     * @param MovieHydrator $movieHydrator
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $em,
        RequestStack $requestStack,
        MovieHydrator $movieHydrator,
        Security $security
    ) {
        $this->em = $em;
        $this->requestStack = $requestStack;
        $this->movieHydrator = $movieHydrator;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        //TODO : filter & pagination
        $repository = $this->em->getRepository(Movie::class);
        $request = $this->requestStack->getCurrentRequest();
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $repository->createQueryBuilder('m');
        $queryBuilder
            ->setFirstResult(0)
            ->setMaxResults(5)
            ;

        $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);
        if (!$this->isPaginationEnabled($request, $resourceMetadata, $operationName)) {
            return null;
        }

        $itemsPerPage = $resourceMetadata->getCollectionOperationAttribute($operationName, 'pagination_items_per_page', $this->itemsPerPage, true);

        return new Paginator(new DoctrinePaginator($queryBuilder));

//        $res = $repository->findAll();
//        /** @var Movie $movie */
//        foreach ($res as $movie) {
//            yield $this->movieHydrator->hydrate($movie);
//        }
    }

    /**
     * @inheritDoc
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        //@TODO: implement video url with token
        /** @var Movie $movie */
        $movie = $this->em->getRepository(Movie::class)->find($id);
        return !empty($movie) ? $this->movieHydrator->hydrate($movie) : null;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === MovieDto::class;
    }
}