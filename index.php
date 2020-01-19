<?php

use Banky\BootstrapContainer;
use Banky\BootstrapRouter;

require 'vendor/autoload.php';

(new BootstrapRouter())(
    (new BootstrapContainer())()
)();
