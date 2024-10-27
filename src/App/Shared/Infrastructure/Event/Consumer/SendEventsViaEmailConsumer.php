<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Event\Consumer;

use App\Shared\Infrastructure\Event\ReadModel\EmailEventRepository;
use Broadway\Domain\DomainMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'messenger.bus.event.async', fromTransport: 'events', priority: 10)]
class SendEventsViaEmailConsumer
{
    public function __construct(private readonly EmailEventRepository $eventEmailRepository)
    {
    }

    public function __invoke(DomainMessage $event): void
    {
        $this->eventEmailRepository->send($event);
    }
}
