<?php declare(strict_types=1);

namespace Banky\Customer\RegisterCustomer;

class RegistrationBonus
{
    public static function random() : int
    {
        return rand(5, 20);
    }
}