<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\MigrationsFactory;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Version\MigrationFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

final class ContainerAwareFactory implements MigrationFactory
{
    public function __construct(private readonly Connection $connection, private readonly LoggerInterface $logger, private readonly ?\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
    }

    public function createVersion(string $migrationClassName): AbstractMigration
    {
        $instance = new $migrationClassName(
            $this->connection,
            $this->logger
        );

        if ($instance instanceof ContainerAwareInterface) {
            $instance->setContainer($this->container);
        }

        return $instance;
    }
}
