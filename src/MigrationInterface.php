<?php
namespace Pushin\IncrementalVersionMigrator;

interface MigrationInterface
{
    public function getNumber();

    public function getPrevNumber();

    public function setPrevNumber($version);

    public function up();

    public function down();
}