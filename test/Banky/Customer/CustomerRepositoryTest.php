<?php declare(strict_types=1);

namespace BankyTest\Customer;

use Banky\BootstrapContainer;
use Banky\Customer\CustomerRepository;
use Banky\BootstrapDatabase;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CustomerRepositoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp() : void
    {
        $this->container = (new BootstrapContainer())();

        $bootstrapDatabase = $this->container->get(BootstrapDatabase::class);

        $databaseConfig = require __DIR__ . '/../../../src/databaseConfig.php';
        $bootstrapDatabase($databaseConfig['database']);

        parent::setUp();
    }

    /** @test */
    public function customerDoesNotExist() : void
    {
        $repository = $this->container->get(CustomerRepository::class);
        self::assertFalse(
            $repository->customerWithEmailExists('does@not.com')
        );
    }

    /** @test */
    public function persistCustomerAndCheckIfExists() : void
    {
        $repository = $this->container->get(CustomerRepository::class);
        $customer = TestCustomer::generate();
        $repository->save($customer);

        self::assertTrue(
            $repository->customerWithEmailExists($customer->getEmail())
        );
    }
}