<?php
namespace Pushin\IncrementalVersionMigrator;

class InvalidVersionNumberException extends \Exception
{
    protected $message = 'Invalid version number';
} 