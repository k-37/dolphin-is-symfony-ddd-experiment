<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Event\ReadModel;

use App\Shared\Infrastructure\Persistence\ReadModel\Repository\EmailRepository;
use Broadway\Domain\DomainMessage;

final class EmailEventRepository extends EmailRepository
{
    public function send(DomainMessage $message): void
    {
        $subject = sprintf(
            'New %s event',
            $message->getType(),
        );

        $body = sprintf(
            'On %s new %s event %s',
            $message->getRecordedOn()->toString(),
            $message->getType(),
            \serialize($message->getPayload()),
        );

        $this->sendEmailToAdmin($subject, $body);
    }
}
