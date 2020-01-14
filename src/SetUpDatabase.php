<?php declare(strict_types=1);

namespace BankApp;

use BankApp\Persistence\DatabaseClient;

final class SetUpDatabase
{
    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function __invoke(string $databaseName) : void
    {
        $this->databaseClient->rawSql("CREATE DATABASE IF NOT EXISTS bank;");
        $this->databaseClient->rawSql("USE $databaseName;");

        $this->databaseClient->rawSql(
            'CREATE TABLE IF NOT EXISTS customers (
                firstName varchar(255), 
                lastName varchar(255), 
                gender varchar(255), 
                country varchar(255), 
                email varchar(255), 
                bonus int(3)
            )'
        );
    }
}