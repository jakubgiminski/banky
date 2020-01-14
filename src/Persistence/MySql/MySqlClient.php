<?php declare(strict_types=1);

namespace BankApp\Persistence\MySql;

use BankApp\Persistence\DatabaseClient;
use BankApp\Persistence\SqlGenerator;
use mysqli;

final class MySqlClient implements DatabaseClient
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(string $tableName, array $query) : array
    {
        $result = $this->connection->query(
            SqlGenerator::select($tableName, $query)
        )->fetch_array();

        $this->checkForError();

        return $result ?: [];
    }

    public function insert(string $tableName, array $record) : void
    {
        $this->connection->query(
            SqlGenerator::insert($tableName, $record)
        );

        $this->checkForError();
    }

    public function rawSql(string $sql)
    {
        $result = $this->connection->query($sql);
        $this->checkForError();

        return $result;
    }

    private function checkForError() : void
    {
        if ($this->connection->error) {
            throw new MySqlClientException($this->connection->error);
        }
    }
}