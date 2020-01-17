<?php declare(strict_types=1);

namespace Banky\Customer;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;
use Throwable;

class CustomerIdCollection extends Collection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(
            $elements,
            Type::object(CustomerId::class),
            new UniqueIndex(function (CustomerId $customerId) : string {
                return (string) $customerId;
            })
        );
    }

    public function tryAdding(CustomerId $customerId) : void
    {
        try {
            $this->add($customerId);
        } catch (Throwable $exception) {
            return;
        }
    }
}