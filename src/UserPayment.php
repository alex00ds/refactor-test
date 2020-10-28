<?php


namespace Kl;


use Kl\Traits\ToArray;

class UserPayment
{
    use ToArray;

    public $id;

    public $userId;

    public $type;

    public $balanceBefore;

    public $amount;

    public function __construct($userId, $type, $balanceBefore, $amount, $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->type = $type;
        $this->balanceBefore = $balanceBefore;
        $this->amount = $amount;
    }
}