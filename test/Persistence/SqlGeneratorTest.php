<?php declare(strict_types=1);

namespace BankAppTest\Persistence;

use BankApp\Persistence\SqlGenerator;
use PHPUnit\Framework\TestCase;

class SqlGeneratorTest extends TestCase
{
    /** @test */
    public function insert() : void
    {
        $sql = SqlGenerator::insert(
            'people',
            [
                'name' => 'Donald',
                'profession' => 'president',
            ]
        );

        self::assertSame(
            'INSERT INTO people (name, profession) VALUES (\'Donald\', \'president\');',
            $sql
        );
    }

    /** @test */
    public function select() : void
    {
        $sql = SqlGenerator::select(
            'people',
            [
                'name' => 'Donald',
                'profession' => 'president',
            ]
        );

        self::assertSame(
            'SELECT * FROM people WHERE name = \'Donald\' AND profession = \'president\';',
            $sql
        );
    }
}