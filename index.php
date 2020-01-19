<?php

use Banky\BootstrapContainer;
use Banky\BootstrapRouter;

require 'vendor/autoload.php';

$router = (new BootstrapRouter())(
    (new BootstrapContainer())()
);

$router();
