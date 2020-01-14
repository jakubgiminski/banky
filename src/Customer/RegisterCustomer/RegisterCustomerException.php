<?php declare(strict_types=1);

namespace BankApp\Customer\RegisterCustomer;

use RuntimeException;

class RegisterCustomerException extends RuntimeException
{
    public static function customerAlreadyRegistered($email) : self
    {
        return new self("Customer with email `$email` has already been registered");
    }
}