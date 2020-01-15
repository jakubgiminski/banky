<?php declare(strict_types=1);

namespace Banky\Customer;

use RuntimeException;

class CustomerDoesNotExistsException extends RuntimeException
{
    public function __construct(CustomerId $customerId)
    {
        parent::__construct("Customer `$customerId` does not exist");
    }
}