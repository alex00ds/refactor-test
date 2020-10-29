<?php

namespace Kl\Interfaces;

use Kl\UserPayment;

interface IUserPaymentRepository
{
    public function add(UserPayment $payment);
}