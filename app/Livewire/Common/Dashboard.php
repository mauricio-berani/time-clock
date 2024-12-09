<?php

namespace App\Livewire\Common;

use App\Exceptions\TimeBetweenClockInTooShort;
use App\Livewire\BaseComponent;
use App\Models\Auth\User;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class Dashboard extends BaseComponent
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->guard('web')->user();
    }

    public function recordTime()
    {
        try {
            DB::beginTransaction();

            if (RateLimiter::tooManyAttempts($this->user->id, 1)) {
                throw new TimeBetweenClockInTooShort;
            }

            $this->user->timeRecords()->create();
            RateLimiter::hit($this->user->id, config('client.time_between_clock_in'));
            DB::commit();

            $this->success(
                title: __('feedback.time_recorded_with_success'),
                position: 'toast-top',
                timeout: 3000,
            );
        } catch (TimeBetweenClockInTooShort | Throwable $error) {
            DB::rollBack();
            logger()->error($error->getMessage());

            $errorMessage = $error instanceof TimeBetweenClockInTooShort ?
                $error->getMessage() :
                __('feedback.time_recorded_with_error');

            $this->error($errorMessage, position: 'toast-top');
        }
    }

    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.common.dashboard', [
            'welcomeMessage' => session('welcome-message'),
        ]);
    }
}
