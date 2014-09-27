<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\MigrationInterface;
use Pushin\IncrementalVersionMigrator\MigrationsProviderInterface;

class MigrationsProvider implements MigrationsProviderInterface
{
    /**
     * @var MigrationInterface[]
     */
    protected $migrations;

    public function __construct($migrations)
    {
        $this->migrations = $migrations;
    }

    public function get()
    {
        return $this->migrations;
    }

} 