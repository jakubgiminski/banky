<?php declare(strict_types=0);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use BankyFramework\Serializable;
use Comquer\ArrayValidator\ArrayValidator;

class Transaction implements Serializable
{
    private TransactionId $id;

    private Money $amount;

    private Money $balanceAfterwards;

    private CustomerId $customerId;

    private int $timestamp;

    private Money $bonus;

    public function __construct(TransactionId $id, Money $amount, Money $balanceAfterwards, CustomerId $customerId, int $timestamp, Money $bonus = null)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->balanceAfterwards = $balanceAfterwards;
        $this->customerId = $customerId;
        $this->timestamp = $timestamp;
        $this->bonus = $bonus ?: new Money();
    }

    public static function deserialize(array $record) : self
    {
        self::validateSerialized($record);
        return new self(
            new TransactionId($record['id']),
            new Money($record['amount']),
            new Money($record['balanceAfterwards']),
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
            'balanceAfterwards',
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
            'balanceAfterwards' => $this->balanceAfterwards->getValue(),
            'customerId' => (string) $this->customerId,
            'timestamp' => $this->timestamp,
            'bonus' => $this->bonus->getValue(),
        ];
    }
}