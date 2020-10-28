<?php


namespace Kl;


class UserPaymentDbTable
{
    private $storage = [];

    public function add($paymentData)
    {
        if (empty($paymentData['id'])) {
            $paymentData['id'] = count($this->storage) + 1;
        }

        $this->storage[] = $paymentData;

        return $paymentData['id'];
    }
}
