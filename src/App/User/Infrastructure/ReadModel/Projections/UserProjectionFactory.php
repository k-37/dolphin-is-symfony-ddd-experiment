<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ReadModel\Projections;

use App\Shared\Domain\Exception\DateTimeException;
use App\User\Domain\Event\UserWasCreated;
use App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use App\User\Infrastructure\ReadModel\Postgresql\PostgresqlReadModelUserRepository;
use App\User\Infrastructure\ReadModel\UserView;
use Assert\AssertionFailedException;
use Broadway\ReadModel\Projector;
use Doctrine\ORM\NonUniqueResultException;

final class UserProjectionFactory extends Projector
{
    public function __construct(private readonly PostgresqlReadModelUserRepository $repository)
    {
    }

    /**
     * @throws AssertionFailedException
     * @throws DateTimeException
     */
    protected function applyUserWasCreated(UserWasCreated $userWasCreated): void
    {
        $userReadModel = UserView::fromSerializable($userWasCreated);

        $this->repository->add($userReadModel);
    }
}
