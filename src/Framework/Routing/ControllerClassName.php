<?php declare(strict_types=1);

namespace BankyFramework\Routing;

use Comquer\Reflection\ClassName\ClassName;

class ControllerClassName extends ClassName
{
    public function __construct(string $className)
    {
        parent::__construct($className);
        $this->mustHaveMethod('__invoke');
    }
}