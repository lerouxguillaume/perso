<?php


namespace App\DataProvider;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Documents\Movie;
use App\Entity\Documents\Serie;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use RuntimeException;

class ContentDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $managerRegistry;
    private $collectionExtensions;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param iterable $collectionExtensions
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        iterable $collectionExtensions = []
    ){
        $this->managerRegistry = $managerRegistry;
        $this->collectionExtensions = $collectionExtensions;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Movie::class === $resourceClass || Serie::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, $context = [])
    {
        /** @var EntityManagerInterface $manager */
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);
        if (!method_exists($repository, 'createQueryBuilder')) {
            throw new RuntimeException('The repository class must have a "createQueryBuilder" method.');
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $repository->createQueryBuilder('o');

        $queryBuilder->addCriteria($repository->getCriteria());

        $queryNameGenerator = new QueryNameGenerator();
        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);

            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}