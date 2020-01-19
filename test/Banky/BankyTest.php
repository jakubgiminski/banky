<?php declare(strict_types=1);

namespace BankyTes;

use Banky\BootstrapContainer;
use Banky\BootstrapDatabase;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class BankyTest extends TestCase
{
    protected ContainerInterface $container;

    public function setUp() : void
    {
        $this->container = (new BootstrapContainer())();

        $bootstrapDatabase = $this->container->get(BootstrapDatabase::class);

        $databaseConfig = require __DIR__ . '/../../src/databaseConfig.php';
        $bootstrapDatabase($databaseConfig['database']);

        parent::setUp();
    }
}