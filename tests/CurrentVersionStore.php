<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\CurrentVersionStoreInterface;

class CurrentVersionStore implements CurrentVersionStoreInterface
{
    protected $version = 0;

    public function set($version)
    {
        $this->version = $version;
    }

    public function get()
    {
        return $this->version;
    }

} 