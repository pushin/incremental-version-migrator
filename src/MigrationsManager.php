<?php
namespace Pushin\IncrementalVersionMigrator;

class MigrationsManager
{
    /**
     * @var MigrationsProviderInterface[]
     */
    protected $providers;

    /** @var MigrationInterface[] */
    protected $migrations;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function getLastVersion()
    {
        /** @var MigrationInterface $lastMigration */
        $lastMigration = array_pop($this->getMigrations());

        if (!$lastMigration) {
            return 0;
        }

        return $lastMigration->getNumber();
    }

    public function getChain($from, $to)
    {
        if (!$this->isValidVersionNumber($from) || !$this->isValidVersionNumber($to)) {
            throw new InvalidVersionNumberException();
        }

        return $from < $to
            ? new MigrationsChain($this->getNormalRange($from, $to))
            : new MigrationsChain($this->getReverseRange($from, $to), true)
        ;
    }

    public function isValidVersionNumber($number)
    {
        if (!is_int($number)) {
            return false;
        }

        if (!$this->hasMigration($number)) {
            return false;
        }

        return true;
    }

    public function hasMigration($version)
    {
        if (0 === $version) {
            return true;
        }

        $migrations = $this->getMigrations();
        return isset($migrations[$version]);
    }

    protected function getReverseRange($from, $to)
    {
        return array_reverse($this->getNormalRange($to, $from), true);
    }

    /**
     * @param $from
     * @param $to
     * @return MigrationInterface[]
     */
    protected function getNormalRange($from, $to)
    {
        $range = array();
        foreach($this->getMigrations() as $version => $migration) {
            if ($version > $from && $version <= $to) {
                $range[$version] = $migration;
            }
        }
        return $range;
    }

    /**
     * @return MigrationInterface[]
     */
    protected function getMigrations()
    {
        if (null === $this->migrations) {
            $this->migrations = $this->loadMigrations();
        }
        return $this->migrations;
    }

    protected function loadMigrations()
    {
        /** @var MigrationInterface[] $migrations */
        $migrations = array();
        foreach($this->providers as $provider) {
            foreach($provider->get() as $migration) {
                $migrations[$migration->getNumber()] = $migration;
            }
        }

        ksort($migrations);

        $prevVersion = 0;

        foreach($migrations as $migration) {
            $migration->setPrevNumber($prevVersion);
            $prevVersion = $migration->getNumber();
        }

        return $migrations;
    }
} 