<?php declare(strict_types=1);

namespace BankyTest\Customer;

use Banky\Customer\CustomerRepository;
use BankyTest\BankyTest;

class CustomerRepositoryTest extends BankyTest
{
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