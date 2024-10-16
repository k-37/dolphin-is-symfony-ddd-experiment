<?php

declare(strict_types=1);

namespace Tests\App\Shared\Application;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

abstract class ApplicationTestCase extends KernelTestCase
{
    private ?CommandBusInterface $commandBus;


    protected function setUp(): void
    {
        self::bootKernel();

        $this->commandBus = $this->service(CommandBusInterface::class);
    }

    /**
     * @throws Throwable
     */
    protected function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }

    /**
     * @return object|null
     */
    protected function service(string $serviceId)
    {
        return $this->getContainer()->get($serviceId);
    }

    protected function fireTerminateEvent(): void
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->service('event_dispatcher');

        $dispatcher->dispatch(
            new TerminateEvent(
                static::$kernel,
                Request::create('/'),
                new Response()
            ),
            KernelEvents::TERMINATE
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->commandBus = null;
    }
}
