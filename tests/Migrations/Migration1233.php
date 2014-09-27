<?php
namespace Pushin\IncrementalVersionMigrator\Tests\Migrations;

use Pushin\IncrementalVersionMigrator\AbstractMigration;
use Pushin\IncrementalVersionMigrator\MigrationInterface;

class Migration1233 implements MigrationInterface
{
    protected $version;

    public function getNumber()
    {
        return 1233;
    }

    public function up()
    {

    }

    public function down()
    {

    }

    public function getPrevNumber()
    {
        return $this->version;
    }

    public function setPrevNumber($version)
    {
        $this->version = $version;
    }


} 