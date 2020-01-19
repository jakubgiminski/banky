<?php declare(strict_types=1);

namespace BankyTest;

use Banky\BootstrapContainer;
use Banky\BootstrapDatabase;
use Banky\Customer\Customer;
use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;
use Banky\Transaction\Money;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionId;
use Banky\Transaction\TransactionRepository;
use BankyTest\Customer\TestCustomer;
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

    protected function registerCustomer() : Customer
    {
        $customerRepository = $this->container->get(CustomerRepository::class);
        $customer = TestCustomer::generate();
        $customerRepository->save($customer);

        return $customer;
    }

    protected function registerCustomerAndDepositMoney(Money $amount) : CustomerId
    {
        $customer = $this->registerCustomer();
        $transactionRepository = $this->container->get(TransactionRepository::class);
        $transactionRepository->save(new Transaction(
            TransactionId::generate(),
            $amount,
            $amount,
            $customer->getId(),
            microtime(true),
        ));
        return $customer->getId();
    }
}