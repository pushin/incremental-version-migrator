<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\MigrationsProvider;

class MigrationsProviderTest extends BaseTestCase
{
    public function testGet()
    {
        $provider = new MigrationsProvider(
            '\Pushin\IncrementalVersionMigrator\Tests\Migrations',
            __DIR__ . '/Migrations'
        );
        $migrations = $provider->get();
        $this->assertCount(3, $migrations);
        $this->assertContainsOnlyInstancesOf('Pushin\IncrementalVersionMigrator\MigrationInterface', $migrations);
    }
} 