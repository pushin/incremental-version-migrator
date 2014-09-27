<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\MigrationsChain;

class MigrationsChainTest extends BaseTestCase
{
    public function testIsValidValid()
    {
        new MigrationsChain(array(
            new Migration(1),
            new Migration(2),
            new Migration(3),
        ));
    }

    /**
     * @expectedException \Pushin\IncrementalVersionMigrator\InvalidMigrationsChainException
     */
    public function testIsValidInvalid()
    {
        new MigrationsChain(array(
            new Migration(1),
            new Migration(2),
            new Migration(3),
        ), true);
    }
}