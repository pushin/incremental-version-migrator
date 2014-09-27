<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\MigrationsManager;
use Pushin\IncrementalVersionMigrator\Migrator;

class MigratorTest extends BaseTestCase
{
    public function testMigrate()
    {
        $store = new CurrentVersionStore();

        $var = 0;

        $incVar = function() use (&$var) {
            $var++;
        };

        $decVar = function() use (&$var) {
            $var--;
        };

        $migrator = $this->buildMigrator(array(
            new Migration(1, $incVar, $decVar),
            new Migration(4, $incVar, $decVar),
        ));

        $migrator->migrate();
        $this->assertEquals(4, $migrator->getCurrentVersionNumber());
        $this->assertEquals(2, $var);

        $migrator->migrate();
        $this->assertEquals(4, $migrator->getCurrentVersionNumber());
        $this->assertEquals(2, $var);

        $var = 0;
        $migrator = $this->buildMigrator(array(
            new Migration(1, $incVar, $decVar),
            new Migration(4, $incVar, $decVar),
            new Migration(47, $incVar, $decVar),
            new Migration(45, $incVar, $decVar),
        ));

        $migrator->migrate();
        $this->assertEquals(47, $migrator->getCurrentVersionNumber());
        $this->assertEquals(4, $var);

        $migrator->migrate(0);
        $this->assertEquals(0, $migrator->getCurrentVersionNumber());
        $this->assertEquals(0, $var);
    }
} 