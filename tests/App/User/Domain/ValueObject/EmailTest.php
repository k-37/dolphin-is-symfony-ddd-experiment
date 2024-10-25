<?php

declare(strict_types=1);

namespace Tests\App\User\Domain\ValueObject;

use App\User\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     *
     * @throws \Assert\AssertionFailedException
     */
    public function invalid_email_should_throw_an_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Email::fromString('invalid@');
    }

    /**
     * @test
     *
     * @group unit
     *
     * @throws \Assert\AssertionFailedException
     */
    public function valid_email_should_be_able_to_convert_to_string(): void
    {
        $email = Email::fromString('valid@example.com');

        self::assertSame('valid@example.com', $email->toString());
        self::assertSame('valid@example.com', (string) $email);
    }
}
