<?php declare(strict_types=1);

namespace BankApp\Customer\RegisterCustomer;

use BankApp\Http\Request;

class RegisterCustomerRequest extends Request
{
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->requireStringParameter('firstName');
        $this->requireStringParameter('lastName');
        $this->requireStringParameter('gender');
        $this->requireStringParameter('country');
        $this->requireEmailParameter('email');
    }
}