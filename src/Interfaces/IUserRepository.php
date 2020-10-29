<?php

namespace Kl\Interfaces;

use Kl\User;

interface IUserRepository
{
    public function updateUser(User $user);
}