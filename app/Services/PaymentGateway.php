<?php

namespace App\Services;

class PaymentGateway {
    private $payments = [];

    /**
     * Register Payment Provider
     *
     * @param string $name
     * @param object $object
     * @return void
     */
    public function register(string $name, object $object)
    {
        $this->payments[$name] = $object;
    }

    public function getStatus(string $code)
    {
    }
}