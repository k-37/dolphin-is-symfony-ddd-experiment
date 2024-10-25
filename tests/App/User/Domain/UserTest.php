<?php

declare(strict_types=1);

namespace Tests\App\User\Domain;

use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Exception\EmailAlreadyExistException;
use App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use App\User\Domain\User;
use App\User\Domain\ValueObject\Auth\Credentials;
use App\User\Domain\ValueObject\Auth\HashedPassword;
use App\User\Domain\ValueObject\Email;
use Broadway\Domain\DomainMessage;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase implements UniqueEmailSpecificationInterface
{
    private bool $isUniqueException = false;

    /**
     * @test
     *
     * @group unit
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function given_a_valid_email_it_should_create_a_user_instance(): void
    {
        $emailString = 'valid@example.com';

        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString($emailString),
                HashedPassword::encode('password')
            ),
            $this
        );

        self::assertSame($emailString, $user->email());
        self::assertNotNull($user->uuid());

        $events = $user->getUncommittedEvents();

        self::assertCount(1, $events->getIterator(), 'Only one event should be in the buffer');

        /** @var DomainMessage $event */
        $event = $events->getIterator()->current();

        self::assertInstanceOf(UserWasCreated::class, $event->getPayload(), 'First event should be UserWasCreated');
    }

    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool
    {
        if ($this->isUniqueException) {
            throw new EmailAlreadyExistException();
        }

        return true;
    }
}
