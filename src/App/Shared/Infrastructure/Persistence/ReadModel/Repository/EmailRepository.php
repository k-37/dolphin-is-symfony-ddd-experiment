<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\ReadModel\Repository;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

abstract class EmailRepository
{
    public function __construct(
        private MailerInterface $mailer,
        #[Autowire('%admin_email%')] private string $adminEmail,
    ) {
    }

    public function sendEmailToAdmin(string $subject, string $body): void
    {
        $this->mailer->send((new Email())
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->subject($subject)
            ->text($body)
        );
    }
}
