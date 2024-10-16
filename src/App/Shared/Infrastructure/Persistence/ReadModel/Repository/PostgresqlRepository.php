<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\ReadModel\Repository;

use App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Throwable;

abstract class PostgresqlRepository
{
    protected EntityRepository $repository;

    public function __construct(protected EntityManagerInterface $entityManager)
    {
        $this->setEntityManager();
    }

    abstract protected function setEntityManager(): void;

    public function register(object $model): void
    {
        $this->entityManager->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    protected function oneOrException(QueryBuilder $queryBuilder, mixed $hydration = AbstractQuery::HYDRATE_OBJECT): mixed
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult($hydration)
        ;

        if (null === $model) {
            throw new NotFoundException();
        }

        return $model;
    }

    public function isHealthy(): bool
    {
        $connection = $this->entityManager->getConnection();

        try {
            $dummySelectSQL = $connection->getDatabasePlatform()->getDummySelectSQL();
            $connection->executeQuery($dummySelectSQL);

            return true;
        } catch (Throwable) {
            $connection->close();

            return false;
        }
    }
}
