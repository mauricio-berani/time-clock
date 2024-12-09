<?php

namespace App\Actions\User;

use App\Exceptions\TimeBetweenClockInTooShort;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class RecordTimeAction
{
    public function __construct(protected User $user) {}

    public function handle(): void
    {
        try {
            DB::beginTransaction();


            if (RateLimiter::tooManyAttempts($this->user->id, 1)) {
                throw new TimeBetweenClockInTooShort;
            }

            $this->user->timeRecords()->create();

            RateLimiter::hit($this->user->id, config('client.time_between_clock_in'));

            DB::commit();
        } catch (Throwable $error) {
            DB::rollBack();

            logger()->error($error->getMessage());
        }
    }
}
