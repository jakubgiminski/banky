<?php declare(strict_types=1);

namespace BankApp\Customer\RegisterCustomer;

use BankApp\Customer\Customer;
use BankApp\Http\Response;

class RegisterCustomerResponse extends Response
{
    public static function fromCustomer(Customer $customer) : self
    {
        return new self(201, $customer->serialize());
    }
}