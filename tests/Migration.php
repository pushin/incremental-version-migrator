<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

use Pushin\IncrementalVersionMigrator\AbstractMigration;

class Migration extends AbstractMigration
{
    protected $version;
    protected $upAction;
    protected $downAction;
    protected $next;
    protected $prev;

    public function __construct($version, \Closure $upAction = null, \Closure $downAction = null)
    {
        $this->downAction = $downAction;
        $this->upAction = $upAction;
        $this->version = $version;
    }

    public function getNumber()
    {
        return $this->version;
    }

    public function up()
    {
        if ($this->upAction) {
            $this->upAction->__invoke();
        }
    }

    public function down()
    {
        if ($this->downAction) {
            $this->downAction->__invoke();
        }
    }

}