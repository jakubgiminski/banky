<?php declare(strict_types=1);

namespace BankyFramework;

use Ramsey\Uuid\Uuid;

abstract class Id
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function generate() : self
    {
        return new static((string) Uuid::uuid1());
    }

    public function __toString() : string
    {
        return $this->id;
    }
}