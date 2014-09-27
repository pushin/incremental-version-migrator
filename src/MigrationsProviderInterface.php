<?php
namespace Pushin\IncrementalVersionMigrator;

interface MigrationsProviderInterface
{
    /**
     * @return MigrationInterface[]
     */
    public function get();
}