<?php

namespace App\Policies;

use App\Models\Auth\User;

class BasePolicy
{
    protected $user;

    public function __construct()
    {
        $this->user = User::find(auth()->guard('web')->user()->id);
    }
}
