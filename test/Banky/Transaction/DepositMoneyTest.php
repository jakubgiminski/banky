<?php declare(strict_types=1);

namespace BankyTest\Transaction;

use Banky\Transaction\DepositMoney\DepositMoneyController;
use Banky\Transaction\DepositMoney\DepositMoneyRequest;
use BankyFramework\Http\CreateResourceResponse;
use BankyTest\BankyTest;

class DepositMoneyTest extends BankyTest
{
    /** @test */
    public function successfullyDepositMoney() : void
    {
        $controller = $this->container->get(DepositMoneyController::class);
        $customer = $this->registerCustomer();

        $request = new DepositMoneyRequest([
            'customerId' => (string) $customer->getId(),
            'amount' => 10.00,
        ]);

        $response = $controller($request);

        self::assertInstanceOf(
            CreateResourceResponse::class,
            $response
        );
    }

    /** @test */
    public function depositMoneyThreeTimesAndGetBonus() : void
    {
        $controller = $this->container->get(DepositMoneyController::class);
        $customer = $this->registerCustomer();

        $request = new DepositMoneyRequest([
            'customerId' => (string) $customer->getId(),
            'amount' => 10.00,
        ]);

        $controller($request);
        $controller($request);
        $response = $controller($request);

        $expectedBonus = $customer->getBonus() * 10 / 100;
        $bonusReceived = json_decode($response->serialize(), true)['message']['bonus'];

        self::assertEquals($expectedBonus, $bonusReceived);
    }
}