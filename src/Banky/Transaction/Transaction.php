<?php declare(strict_types=1);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use BankyFramework\Money;
use BankyFramework\Serializable;

class Transaction implements Serializable
{
    private TransactionId $id;

    private Money $amount;

    private CustomerId $customerId;

    private int $timestamp;

    public function __construct(TransactionId $id, Money $amount, CustomerId $customerId, int $timestamp)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->customerId = $customerId;
        $this->timestamp = $timestamp;
    }

    public function getId() : TransactionId
    {
        return $this->id;
    }

    public function getAmount() : Money
    {
        return $this->amount;
    }

    public function getCustomerId() : CustomerId
    {
        return $this->customerId;
    }

    public function getTimestamp() : int
    {
        return $this->timestamp;
    }

    public function serialize() : array
    {
        return [
            'id' => (string) $this->id,
            'amount' => $this->amount->getValue(),
            'customerId' => (string) $this->customerId,
            'timestamp' => $this->timestamp,
        ];
    }
}