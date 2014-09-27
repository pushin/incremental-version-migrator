<?php
namespace Pushin\IncrementalVersionMigrator;

class Migrator
{
    protected $currentVersionStore;

    protected $migrations;

    public function __construct(CurrentVersionStoreInterface $currentVersionStore, MigrationsManager $migrations)
    {
        $this->currentVersionStore = $currentVersionStore;
        $this->migrations = $migrations;
    }

    public function migrate($versionNumber = null)
    {
        if ($versionNumber === null) {
            $versionNumber = $this->migrations->getLastVersion();
        }

        if (null === $versionNumber) {
            return;
        }

        $this->migrateToVersion($versionNumber);
    }

    protected function migrateToVersion($versionNumber)
    {
        if (!$this->migrations->isValidVersionNumber($versionNumber)) {
            throw new InvalidVersionNumberException();
        }

        $currentVersionNumber = $this->getCurrentVersionNumber();

        if ($currentVersionNumber == $versionNumber) {
            return;
        }

        $chain = $this->migrations->getChain($currentVersionNumber, $versionNumber);

        foreach($chain->getMigrations() as $migration) {
            if ($chain->isReverse()) {
                $migration->down();
                $this->currentVersionStore->set($migration->getPrevNumber());
            } else {
                $migration->up();
                $this->currentVersionStore->set($migration->getNumber());
            }
        }

    }

    public function getCurrentVersionNumber()
    {
        return $this->currentVersionStore->get();
    }
}
