<?php declare(strict_types=1);

namespace BankyTest\Customer;

use Banky\Customer\Customer;
use Banky\Customer\CustomerId;
use Banky\Customer\RegisterCustomer\RegistrationBonus;

final class TestCustomer extends Customer
{
    public static function generate() : self
    {
        return new self(
            CustomerId::generate(),
            uniqid('first_name_'),
            uniqid('last_name_'),
            uniqid('gender_'),
            uniqid('country_'),
            uniqid('email_'),
            RegistrationBonus::random()
        );
    }
}