<?php declare(strict_types=1);

namespace BankyTest\Transaction;

use Banky\Transaction\Money;
use Banky\Transaction\WithdrawMoney\WithdrawMoneyController;
use Banky\Transaction\WithdrawMoney\WithdrawMoneyException;
use Banky\Transaction\WithdrawMoney\WithdrawMoneyRequest;
use BankyFramework\Http\CreateResourceResponse;
use BankyTest\BankyTest;

class WithdrawMoneyTest extends BankyTest
{
    /** @test */
    public function successfullyWithdrawMoney() : void
    {
        $controller = $this->container->get(WithdrawMoneyController::class);
        $depositAmount = new Money(100);
        $withdrawalAmount = new Money(10);

        $customerId = $this->registerCustomerAndDepositMoney($depositAmount);

        $request = new WithdrawMoneyRequest([
            'customerId' => (string) $customerId,
            'amount' => $withdrawalAmount->getValue(),
        ]);

        /** @var CreateResourceResponse $response */
        $response = $controller($request);

        self::assertEquals(
            $depositAmount->subtract($withdrawalAmount)->getValue(),
            json_decode($response->serialize(), true)['message']['balanceAfterwards']
        );
    }

    /** @test */
    public function amountExceedsAvailableBalance() : void
    {
        $controller = $this->container->get(WithdrawMoneyController::class);
        $depositAmount = new Money(10);
        $withdrawalAmount = new Money(100);

        $customerId = $this->registerCustomerAndDepositMoney($depositAmount);

        $request = new WithdrawMoneyRequest([
            'customerId' => (string) $customerId,
            'amount' => $withdrawalAmount->getValue(),
        ]);

        $exception = WithdrawMoneyException::insufficientFunds($withdrawalAmount, $depositAmount);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $controller($request);
    }
}