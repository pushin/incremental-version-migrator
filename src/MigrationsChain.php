<?php
namespace Pushin\IncrementalVersionMigrator;

class MigrationsChain
{
    /**
     * @var MigrationInterface[]
     */
    protected $migrations;

    protected $isReverse;

    public function __construct($migrations, $isReverse = false)
    {
        $this->isReverse = $isReverse;
        $this->migrations = $migrations;

        if (! $this->isValid()) {
            throw new InvalidMigrationsChainException();
        }

    }

    public function getMigrations()
    {
        return $this->migrations;
    }

    public function isReverse()
    {
        return $this->isReverse;
    }


    /**
     * @return bool
     */
    protected function isValid()
    {
        $versions = array();
        foreach($this->migrations as $migration) {
            $versions[] = intval($migration->getNumber());
        }

        $expectedVersions = $versions;
        sort($expectedVersions);
        if ($this->isReverse) {
            $expectedVersions = array_reverse($expectedVersions);
        }

        $expectedVersions = array_values($expectedVersions);

        return $expectedVersions === $versions;
    }

} 