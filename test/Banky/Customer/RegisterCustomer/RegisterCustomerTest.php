<?php declare(strict_types=1);

namespace BankyTest\Customer\RegisterCustomer;

use Banky\Customer\RegisterCustomer\RegisterCustomerController;
use Banky\Customer\RegisterCustomer\RegisterCustomerException;
use Banky\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankyFramework\Http\CreateResourceResponse;
use BankyTest\BankyTest;
use BankyTest\Customer\TestCustomer;

class RegisterCustomerTest extends BankyTest
{
    /** @test */
    public function successfullyRegisterCustomer() : void
    {
        $controller = $this->container->get(RegisterCustomerController::class);
        $customer = TestCustomer::generate();

        $response = $controller(new RegisterCustomerRequest([
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'gender' => $customer->getGender(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
        ]));

        self::assertInstanceOf(CreateResourceResponse::class, $response);
    }

    /** @test */
    public function customerAlreadyExists() : void
    {
        $controller = $this->container->get(RegisterCustomerController::class);
        $customer = TestCustomer::generate();

        $request = new RegisterCustomerRequest([
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'gender' => $customer->getGender(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
        ]);

        $controller($request);

        $exception = RegisterCustomerException::customerAlreadyRegistered($customer->getEmail());
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $controller($request);
    }
}