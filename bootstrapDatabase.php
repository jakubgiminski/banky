<?php declare(strict_types=1);

use Banky\BootstrapContainer;
use Banky\BootstrapDatabase;

require 'vendor/autoload.php';

try {
    $container = (new BootstrapContainer())();
    $config = require __DIR__ . '/src/databaseConfig.php';
    $container->get(BootstrapDatabase::class)($config['database']);
    echo 'Database bootstrapped successfully.';
} catch (Throwable $exception) {
    echo "Error bootstrapping database: {$exception->getMessage()}";
}