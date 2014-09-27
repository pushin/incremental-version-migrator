<?php

namespace Pushin\IncrementalVersionMigrator;


interface CurrentVersionStoreInterface
{
    /**
     * Save current version's number
     *
     * @param int $version
     */
    public function set($version);

    /**
     * Get saved number of current version
     *
     * @return int
     */
    public function get();
} 