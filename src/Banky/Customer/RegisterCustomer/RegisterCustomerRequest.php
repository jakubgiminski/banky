<?php declare(strict_types=1);

namespace Banky\Customer\RegisterCustomer;

use BankyFramework\Http\Request;

class RegisterCustomerRequest extends Request
{
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->requireStringParameter('firstName');
        $this->requireStringParameter('lastName');
        $this->requireStringParameter('gender');
        $this->requireEmailParameter('email');
        $this->requireParameter('country', function (string $value) : bool {
            return strlen($value) === 2 && $value === strtoupper($value);
        });
    }
}