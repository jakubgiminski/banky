<?php declare(strict_types=1);

namespace Banky\Customer;

use BankyFramework\Serializable;

class Customer implements Serializable
{
    private CustomerId $id;

    private string $firstName;

    private string $lastName;

    private string $gender;

    private string $country;

    private string $email;

    private int $bonus;

    public function __construct(
        CustomerId $id,
        string $firstName,
        string $lastName,
        string $gender,
        string $country,
        string $email,
        int $bonus
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->country = $country;
        $this->email = $email;
        $this->bonus = $bonus;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function serialize() : array
    {
        return [
            'id' => (string) $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'gender' => $this->gender,
            'country' => $this->country,
            'email' => $this->email,
            'bonus' => $this->bonus,
        ];
    }
}