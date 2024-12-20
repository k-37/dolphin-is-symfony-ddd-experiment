<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Specification;

use App\Shared\Domain\Specification\AbstractSpecification;
use App\User\Domain\Exception\EmailAlreadyExistException;
use App\User\Domain\Repository\CheckUserByEmailInterface;
use App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use App\User\Domain\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

final class UniqueEmailSpecification extends AbstractSpecification implements UniqueEmailSpecificationInterface
{
    public function __construct(private readonly CheckUserByEmailInterface $checkUserByEmail)
    {
    }

    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool
    {
        return $this->isSatisfiedBy($email);
    }

    /**
     * @param Email $value
     */
    public function isSatisfiedBy($value): bool
    {
        try {
            if ($this->checkUserByEmail->existsEmail($value)) {
                throw new EmailAlreadyExistException();
            }
        } catch (NonUniqueResultException) {
            throw new EmailAlreadyExistException();
        }

        return true;
    }
}
