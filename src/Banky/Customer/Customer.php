<?php declare(strict_types=1);

namespace Banky\Customer;

class Customer
{
    private string $firstName;

    private string $lastName;

    private string $gender;

    private string $country;

    private string $email;

    private int $bonus;

    public function __construct(string $firstName, string $lastName, string $gender, string $country, string $email, int $bonus)
    {
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'gender' => $this->gender,
            'country' => $this->country,
            'email' => $this->email,
            'bonus' => $this->bonus,
        ];
    }
}