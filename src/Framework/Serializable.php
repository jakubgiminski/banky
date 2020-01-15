<?php declare(strict_types=1);

namespace BankyFramework;

interface Serializable
{
    public function serialize() : array;
}