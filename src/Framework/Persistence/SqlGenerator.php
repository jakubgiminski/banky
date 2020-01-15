<?php declare(strict_types=1);

namespace BankyFramework\Persistence;

final class SqlGenerator
{
    public static function insert(string $tableName, array $record) : string
    {
        $record = array_map(function ($value) {
            return "'$value'";
        }, $record);

        $values = implode(', ', $record);
        $columns = implode(', ', array_keys($record));

        return "INSERT INTO $tableName ($columns) VALUES ($values);";
    }

    public static function select(string $tableName, array $query) : string
    {
        $serialized = '';

        foreach ($query as $key => $value) {
            $serialized .= " $key = '$value' AND";
        }
        $lastSpacePosition = strrpos($serialized, ' ');
        $query = substr($serialized, 0, $lastSpacePosition);

        return "SELECT * FROM $tableName WHERE$query;";
    }
}