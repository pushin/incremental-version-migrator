<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\MigrationsManager;
use Pushin\IncrementalVersionMigrator\Migrator;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildManager($migrations = array())
    {
        return new MigrationsManager(array(new MigrationsProvider($migrations)));
    }

    protected function buildMigrator($migrations = array())
    {
        return new Migrator(new CurrentVersionStore(), $this->buildManager($migrations));

    }
} 