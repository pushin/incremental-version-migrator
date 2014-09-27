<?php
namespace Pushin\IncrementalVersionMigrator;

abstract class AbstractMigration implements MigrationInterface
{
    protected $prevVersion;

    /**
     * @param mixed $prevVersion
     */
    public function setPrevNumber($version)
    {
        $this->prevVersion = $version;
    }

    /**
     * @return mixed
     */
    public function getPrevNumber()
    {
        return $this->prevVersion;
    }


} 