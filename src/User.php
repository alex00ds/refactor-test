<?php


namespace Kl;

use Kl\Traits\ToArray;


class User
{
    use ToArray;

    public $id;

    public $balance;

    public $email;

    public function __construct($id, $balance, $email)
    {
        $this->id = $id;
        $this->balance = $balance;
        $this->email = $email;
    }

}
