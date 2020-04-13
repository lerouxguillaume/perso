<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataProvider\Hydrator\SerieHydrator;
use App\DTO\SerieDto;
use App\Entity\Documents\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SerieDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var SerieHydrator  */
    private $serieHydrator;
    /** @var RequestStack */
    private $requestStack;

    /**
     * SerieDataProvider constructor.
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     * @param SerieHydrator $serieHydrator
     */
    public function __construct(
        EntityManagerInterface $em,
        RequestStack $requestStack,
        SerieHydrator $serieHydrator
    ) {
        $this->em = $em;
        $this->requestStack = $requestStack;
        $this->serieHydrator = $serieHydrator;
    }

    /**
     * @inheritDoc
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        //TODO : filter & pagination
        $repository = $this->em->getRepository(Serie::class);
        $res = $repository->findAll();
        /** @var Serie $serie */
        foreach ($res as $serie) {
            yield $this->serieHydrator->hydrate($serie);
        }
    }

    /**
     * @inheritDoc
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        /** @var Serie $serie */
        $serie = $this->em->getRepository(Serie::class)->find($id);
        return !empty($serie) ? $this->serieHydrator->hydrate($serie) : null;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === SerieDto::class;
    }
}