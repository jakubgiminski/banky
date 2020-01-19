<?php declare(strict_types=1);

namespace Banky;

use Banky\Customer\CustomerRepository;
use Banky\Customer\RegisterCustomer\RegisterCustomerController;
use BankyFramework\Persistence\DatabaseClient;
use BankyFramework\Persistence\MySql\MySqlClient;
use DI\Container;
use mysqli;
use Psr\Container\ContainerInterface;

final class BootstrapContainer
{
    public function __invoke() : ContainerInterface
    {
        $container = new Container();

        $databaseConfig = require __DIR__ . '/../databaseConfig.php';

        $container->set(mysqli::class, new mysqli(
            $databaseConfig['host'],
            $databaseConfig['username'],
            $databaseConfig['password'],
            $databaseConfig['database'],
            $databaseConfig['port'],
        ));

        $databaseClient = $container->get(MySqlClient::class);
        $container->set(DatabaseClient::class, $databaseClient);

        $container->set(CustomerRepository::class, new CustomerRepository($databaseClient));

        $customerRepository = $container->get(CustomerRepository::class);
        $container->set(RegisterCustomerController::class, new RegisterCustomerController($customerRepository));

        return $container;
    }
}