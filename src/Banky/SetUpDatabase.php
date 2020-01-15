<?php declare(strict_types=1);

namespace Banky;

use Banky\Customer\CustomerRepository;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Persistence\DatabaseClient;

final class SetUpDatabase
{
    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function __invoke(string $databaseName) : void
    {
        $this->databaseClient->rawSql("DROP DATABASE IF EXISTS $databaseName;");
        $this->databaseClient->rawSql("CREATE DATABASE $databaseName;");
        $this->databaseClient->rawSql("USE $databaseName;");

        $customersTable = CustomerRepository::TABLE;
        $this->databaseClient->rawSql(
            "CREATE TABLE $customersTable (
                id varchar(100),
                firstName varchar(100), 
                lastName varchar(100), 
                gender varchar(100), 
                country varchar(100), 
                email varchar(100), 
                bonus int(3)
            )"
        );

        $transactionsTable = TransactionRepository::TABLE;
        $this->databaseClient->rawSql(
            "CREATE TABLE $transactionsTable (
                id varchar(100),
                amount varchar(100),
                customerId varchar(100),
                timestamp varchar(10),
                bonus varchar (100)
            )"
        );
    }
}