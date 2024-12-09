<?php

namespace App\Providers;

use App\Models\Auth\User;
use App\Policies\Auth\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class         => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
