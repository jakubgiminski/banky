<?php declare(strict_types=0);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use Banky\Transaction\Money;
use BankyFramework\Serializable;
use Comquer\ArrayValidator\ArrayValidator;

class Transaction implements Serializable
{
    private TransactionId $id;

    private Money $amount;

    private CustomerId $customerId;

    private int $timestamp;

    private Money $bonus;

    public function __construct(TransactionId $id, Money $amount, CustomerId $customerId, int $timestamp, Money $bonus = null)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->customerId = $customerId;
        $this->timestamp = $timestamp;
        $this->bonus = $bonus ?: new Money(0);
    }

    public static function deserialize(array $record) : self
    {
        self::validateSerialized($record);
        return new self(
            new TransactionId($record['id']),
            new Money($record['amount']),
            new CustomerId($record['customerId']),
            $record['timestamp'],
            new Money($record['bonus'])
        );
    }

    private static function validateSerialized(array $record) : void
    {
        ArrayValidator::validateMultipleKeysExist([
            'id',
            'amount',
            'customerId',
            'timestamp',
            'bonus',
        ], $record);
    }

    public function getId() : TransactionId
    {
        return $this->id;
    }

    public function getBonus() : Money
    {
        return $this->bonus;
    }

    public function getAmount() : Money
    {
        return $this->amount;
    }

    public function serialize() : array
    {
        return [
            'id' => (string) $this->id,
            'amount' => $this->amount->getValue(),
            'customerId' => (string) $this->customerId,
            'timestamp' => $this->timestamp,
            'bonus' => $this->bonus->getValue(),
        ];
    }
}