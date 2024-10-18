<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Migrations;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version20241016013214 extends AbstractMigration implements ContainerAwareInterface
{
    private EntityManagerInterface $em;

    private DBALEventStore $eventStore;

    /**
     * @throws \Exception
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        if ($container === null) {
            throw new \Exception('Container is not loaded');
        }

        /** @var DBALEventStore $eventStore */
        $eventStore = $container->get(DBALEventStore::class);
        $this->eventStore = $eventStore;

        /** @var EntityManagerInterface $em */
        $em = $container->get('doctrine.orm.entity_manager');
        $this->em = $em;
    }

    public function up(Schema $schema): void
    {
        $this->em->getConnection()->beginTransaction();

        try {
            $this->eventStore->configureSchema($schema);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    public function down(Schema $schema): void
    {
        $this->em->getConnection()->beginTransaction();

        try {
            $schema->dropTable('events');
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    public function isTransactional(): bool
    {
        return true;
    }
}
