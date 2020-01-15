<?php declare(strict_types=1);

namespace BankyTest\Customer;

use Banky\BootstrapContainer;
use Banky\Customer\CustomerRepository;
use Banky\SetUpDatabase;
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