<?php declare(strict_types=1);

namespace Banky\Customer\RegisterCustomer;

use Banky\Customer\Customer;
use BankyFramework\Http\Response;

class RegisterCustomerResponse extends Response
{
    public static function fromCustomer(Customer $customer) : self
    {
        return new self(201, $customer->serialize());
    }
}