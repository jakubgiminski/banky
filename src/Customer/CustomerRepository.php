<?php declare(strict_types=1);

namespace BankApp\Customer;

use BankApp\Persistence\DatabaseClient;

final class CustomerRepository
{
    public const TABLE = 'customers';

    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function exists(string $email) : bool
    {
        $customers = $this->databaseClient->fetch(
            self::TABLE,
            [
                'email' => $email,
            ]
        );

        return empty($customers) === false;
    }

    public function persist(Customer $customer) : void
    {
        $this->databaseClient->insert(
            self::TABLE,
            $customer->serialize()
        );
    }
}