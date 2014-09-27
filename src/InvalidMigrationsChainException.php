<?php
namespace Pushin\IncrementalVersionMigrator;

class InvalidMigrationsChainException extends \Exception
{
    protected $message = 'Invalid migrations chain exception';
} 