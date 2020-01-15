<?php declare(strict_types=1);

namespace Banky\Customer;

use BankyFramework\Persistence\DatabaseClient;

final class CustomerRepository
{
    public const TABLE = 'customers';

    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function customerWithEmailExists(string $email) : bool
    {
        $customers = $this->databaseClient->fetch(
            self::TABLE,
            [
                'email' => $email,
            ]
        );

        return empty($customers) === false;
    }

    public function save(Customer $customer) : void
    {
        // @todo refactor insert into upsert
        $this->databaseClient->insert(
            self::TABLE,
            $customer->serialize()
        );
    }
}