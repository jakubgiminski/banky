<?php declare(strict_types=1);

namespace BankyTest\Customer\RegisterCustomer;

use Banky\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankyFramework\Http\InvalidRequestException;
use PHPUnit\Framework\TestCase;

class RegisterCustomerRequestTest extends TestCase
{
    /** @test */
    public function validation() : void
    {
        $request = new RegisterCustomerRequest([
            'firstName' => 'Jon',
            'country' => 'Polska',
            'email' => 'invalid',
        ]);

        $exception = InvalidRequestException::fromErrors([
            'Required parameter `lastName` missing',
            'Required parameter `gender` missing',
            'Invalid value of required parameter `email`',
            'Invalid value of required parameter `country`',
        ]);

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $request();
    }
}