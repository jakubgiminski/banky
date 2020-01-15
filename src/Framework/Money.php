<?php declare(strict_types=1);

namespace BankyFramework;

class Money
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = round($value, 2);
    }

    public function getValue() : float
    {
        return $this->value;
    }
}