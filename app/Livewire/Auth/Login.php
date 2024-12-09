<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

class Login extends Component
{
    use Toast;

    public $email;
    public $password;

    protected $rules = [
        'email'     => 'required|email|max:255',
        'password'  => 'required',
    ];

    public function mount()
    {
        if (Auth::check())
            return redirect()->intended(route('dashboard'));
    }

    public function login()
    {
        $credentials = $this->validate();

        if (RateLimiter::tooManyAttempts(strtolower($credentials['email']), 5)) {
            $this->error(trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn(strtolower($credentials['email'])),
            ]), position: 'toast-top toast-center');

            return;
        }

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit(strtolower($credentials['email']));

            $this->error(trans('auth.failed'), position: 'toast-top toast-center');

            return;
        }

        $this->success(
            title: __('auth.welcome', ['name' => auth()->guard('web')->user()->name]),
            position: 'toast-top',
            timeout: 5000,
            redirectTo: route('dashboard')
        );
    }

    #[Layout('components.layouts.empty')]
    public function render()
    {
        return view('livewire.auth.login', [
            'title' => 'Login',
        ]);
    }
}
