<?php declare(strict_types=1);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use BankyFramework\Persistence\DatabaseClient;

class TransactionRepository
{
    public const TABLE = 'transactions';

    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function save(Transaction $transaction) : void
    {
        $this->databaseClient->insert(
            self::TABLE,
            $transaction->serialize()
        );
    }

    public function getLatestDeposits(CustomerId $customerId, int $limit) : TransactionCollection
    {
        $table = self::TABLE;
        $result = $this->databaseClient->rawSql("
            SELECT * FROM $table WHERE customerId = '$customerId' ORDER BY CAST(timestamp as UNSIGNED) DESC LIMIT $limit
        ");

        $deposits = new TransactionCollection();
        if ($result === false) {
            return $deposits;
        }

        foreach ($result as $record) {
            $deposits->add(Transaction::deserialize($record));
        }

        return $deposits;
    }
}