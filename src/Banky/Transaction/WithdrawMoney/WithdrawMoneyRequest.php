<?php declare(strict_types=1);

namespace Banky\Transaction\WithdrawMoney;

use BankyFramework\Http\Request;

class WithdrawMoneyRequest extends Request
{
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->requireStringParameter('customerId');
        $this->requireMoneyParameter('amount');
    }
}