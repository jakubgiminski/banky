<?php declare(strict_types=1);

namespace Banky\Transaction;

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
}