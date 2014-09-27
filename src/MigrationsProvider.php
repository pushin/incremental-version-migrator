<?php
namespace Pushin\IncrementalVersionMigrator;

class MigrationsProvider implements MigrationsProviderInterface
{
    protected $namespace;
    protected $baseDirPath;

    public function __construct($namespace, $path)
    {
        $this->namespace = $namespace;
        $this->baseDirPath = $path;
    }

    /**
     * @return MigrationInterface[]
     */
    public function get()
    {
        $migrations = array();
        foreach($this->getMigrationsClassNames() as $class) {
            $migrations[] = new $class();
        }
        return $migrations;
    }

    protected function getMigrationsClassNames()
    {
        $classNames = array();
        foreach(glob("{$this->baseDirPath}/Migration*.php") as $path) {
            $filename = pathinfo($path, PATHINFO_FILENAME);
            $classNames[] = "{$this->namespace}\\{$filename}";
        }
        return $classNames;
    }


} 