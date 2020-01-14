<?php

use BankApp\BootstrapContainer;
use BankApp\Customer\RegisterCustomer;

require 'vendor/autoload.php';

$container = (new BootstrapContainer())();

$router = new Buki\Router();

$router->get('/', function() {
    return 'Bank App';
});

$router->post('/customers', function () use ($container) {
    try {
        $registerCustomer = $container->get(RegisterCustomer::class);
        $customer = $registerCustomer($_POST);
        return json_encode($customer->serialize());
    } catch (\Throwable $exception) {
        return json_encode(['error' => $exception->getMessage()]);
    }
});

$router->run();
