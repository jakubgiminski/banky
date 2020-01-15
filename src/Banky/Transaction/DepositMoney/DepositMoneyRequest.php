<?php declare(strict_types=1);

namespace Banky\Transaction\DepositMoney;

use BankyFramework\Http\Request;

class DepositMoneyRequest extends Request
{
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->requireStringParameter('customerId');
        $this->requireParameter('amount', function ($value) {
            return is_numeric($value) && $value > 0;
        });
    }
}