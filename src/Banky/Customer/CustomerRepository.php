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
        return $this->customerExists([
            'email' => $email,
        ]);
    }

    public function customerWithIdExists(CustomerId $customerId) : bool
    {
        return $this->customerExists([
            'id' => (string) $customerId,
        ]);
    }

    public function save(Customer $customer) : void
    {
        $this->databaseClient->insert(
            self::TABLE,
            $customer->serialize()
        );
    }

    private function customerExists(array $query)
    {
        $customers = $this->databaseClient->fetch(
            self::TABLE,
            $query
        );

        return empty($customers) === false;
    }

    public function getBonusMultiplier(CustomerId $customerId) : float
    {
        $result = $this->databaseClient->fetch(self::TABLE, [
            'id' => (string) $customerId,
        ]);

        return ((int) $result['bonus']) / 100;
    }
}