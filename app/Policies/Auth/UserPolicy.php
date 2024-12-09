<?php

namespace App\Policies\Auth;

use App\Models\Auth\User;
use App\Enums\Auth\Permissions;
use App\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    public function mount(): bool
    {
        return $this->user->can(Permissions::MOUNT_USER->value, User::class);
    }

    public function list(): bool
    {
        return $this->user->can(Permissions::LIST_USER->value, User::class);
    }

    public function findAll(): bool
    {
        return $this->user->can(Permissions::FIND_ALL_USER->value, User::class);
    }

    public function findOne(): bool
    {
        return $this->user->can(Permissions::FIND_ONE_USER->value, User::class);
    }

    public function create(): bool
    {
        return $this->user->can(Permissions::CREATE_USER->value, User::class);
    }

    public function update(): bool
    {
        return $this->user->can(Permissions::UPDATE_USER->value, User::class);
    }

    public function delete(): bool
    {
        return $this->user->can(Permissions::DELETE_USER->value, User::class);
    }

    public function mountProfile(): bool
    {
        return $this->user->can(Permissions::MOUNT_PROFILE->value, User::class);
    }

    public function updateProfile(): bool
    {
        return $this->user->can(Permissions::UPDATE_PROFILE->value, User::class);
    }
}
