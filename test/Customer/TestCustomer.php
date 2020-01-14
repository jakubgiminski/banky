<?php declare(strict_types=1);

namespace BankAppTest\Customer;

use BankApp\Customer\Customer;

final class TestCustomer extends Customer
{
    public static function generate() : self
    {
        return new self(
            uniqid('first_name_'),
            uniqid('last_name_'),
            uniqid('gender_'),
            uniqid('country_'),
            uniqid('email_'),
            rand(1, 100)
        );
    }
}