<?php

use Banky\BootstrapContainer;
use Banky\Customer\RegisterCustomer\RegisterCustomerController;
use Banky\Customer\RegisterCustomer\RegisterCustomerRequest;
use Banky\Report\GenerateReport\GenerateReportController;
use Banky\Report\GenerateReport\GenerateReportRequest;
use Banky\Transaction\DepositMoney\DepositMoneyController;
use Banky\Transaction\DepositMoney\DepositMoneyRequest;
use Banky\Transaction\WithdrawMoney\WithdrawMoneyController;
use Banky\Transaction\WithdrawMoney\WithdrawMoneyRequest;
use BankyFramework\Routing\Router;

require 'vendor/autoload.php';

$container = (new BootstrapContainer())();
$router = new Router($container);

$router->registerRoute(
    'POST',
    '/customers',
    RegisterCustomerRequest::class,
    RegisterCustomerController::class
);

$router->registerRoute(
    'POST',
    '/deposits',
    DepositMoneyRequest::class,
    DepositMoneyController::class
);

$router->registerRoute(
    'POST',
    '/withdrawals',
    WithdrawMoneyRequest::class,
    WithdrawMoneyController::class
);

$router->registerRoute(
    'GET',
    '/reports',
    GenerateReportRequest::class,
    GenerateReportController::class
);

$router();
