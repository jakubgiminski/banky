<?php declare(strict_types=1);

namespace BankApp;

use BankApp\Customer\CustomerRepository;
use BankApp\Customer\RegisterCustomer\RegisterCustomerController;
use BankApp\Persistence\DatabaseClient;
use BankApp\Persistence\MySql\MySqlClient;
use DI\Container;
use mysqli;
use Psr\Container\ContainerInterface;

final class BootstrapContainer
{
    public function __invoke() : ContainerInterface
    {
        $container = new Container();

        $container->set(mysqli::class, new mysqli(
            '10.19.17.12',
            'root',
            'password',
            'bank',
            3306
        ));

        $databaseClient = $container->get(MySqlClient::class);
        $container->set(DatabaseClient::class, $databaseClient);

        $container->set(CustomerRepository::class, new CustomerRepository($databaseClient));

        $customerRepository = $container->get(CustomerRepository::class);
        $container->set(RegisterCustomerController::class, new RegisterCustomerController($customerRepository));

        return $container;
    }
}