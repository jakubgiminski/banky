<?php declare(strict_types=1);

namespace Banky\Transaction;

class Money
{
    private float $value;

    public function __construct(float $value = 0)
    {
        $this->value = round($value, 2);
    }

    public function getValue() : float
    {
        return $this->value;
    }

    public function multiplyBy(float $number) : self
    {
        $multiplied = $this->getValue() * $number;
        return new self($multiplied);
    }

    public function add(self $money) : self
    {
        return new self($this->value + ($money->getValue()));
    }

    public function subtract(Money $money) : self
    {
        return new self($this->value - ($money->getValue()));
    }

    public function revert() : self
    {
        if ($this->value === 0) {
            return $this;
        }

        if ($this->value > 0) {
            return new self(-$this->value);
        }

        return new self(abs($this->value));
    }

    public function isMoreThan(Money $money) : bool
    {
        return $this->value > $money->getValue();
    }

    public function __toString() : string
    {
        return (string) $this->value;
    }
}
