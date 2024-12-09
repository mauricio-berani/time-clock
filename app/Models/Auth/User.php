<?php

namespace App\Models\Auth;

use App\Enums\Auth\Roles;
use App\Models\User\UserTimeRecord;
use App\Models\User\UserAddress;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasUuids;
    use HasRoles;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'document',
        'birthday',
        'job_title',
        'maanger_id',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $hidden = ['password'];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value)
        );
    }

    protected function managerId(): Attribute
    {
        return Attribute::make(
            set: fn() => auth()->guard('web')->user()->id,
        );
    }

    public function address(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }

    public function timeRecords(): HasMany
    {
        return $this->hasMany(UserTimeRecord::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Roles::ADMINISTRATOR->value);
    }
}
