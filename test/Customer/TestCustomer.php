<?php declare(strict_types=1);

namespace BankAppTest\Customer;

use BankApp\Customer\Customer;
use BankApp\Customer\RegisterCustomer\RegistrationBonus;

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
            RegistrationBonus::random()
        );
    }
}