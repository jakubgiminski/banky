<?php declare(strict_types=1);

namespace BankAppTest\Customer;

use BankApp\BootstrapContainer;
use BankApp\Customer\CustomerRepository;
use BankApp\SetUpDatabase;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CustomerRepositoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp() : void
    {
        $this->container = (new BootstrapContainer())();

        $setUpDatabase = $this->container->get(SetUpDatabase::class);
        $setUpDatabase('bank');

        parent::setUp();
    }

    /** @test */
    public function customerDoesNotExist() : void
    {
        $repository = $this->container->get(CustomerRepository::class);
        self::assertFalse(
            $repository->exists('does@not.com')
        );
    }

    /** @test */
    public function persistCustomerAndCheckIfExists() : void
    {
        $repository = $this->container->get(CustomerRepository::class);
        $customer = TestCustomer::generate();
        $repository->persist($customer);

        self::assertTrue(
            $repository->exists($customer->getEmail())
        );
    }
}