<?php

namespace App\Models\User;

use App\Models\Auth\User;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTimeRecord extends BaseModel
{
    use HasFactory;

    protected $table = 'user_time_records';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
