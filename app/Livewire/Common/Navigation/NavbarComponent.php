<?php

namespace App\Livewire\Common\Navigation;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use app\Traits\ManagesFilesTrait;

class NavbarComponent extends Component
{
    use ManagesFilesTrait;

    public $user;
    public $avatarPath;

    public function mount()
    {
        /** @var \App\Models\Auth\User $user **/
        $this->user = auth()->guard('web')->user();
        $this->avatarPath = $this->getAvatarPath();
    }

    #[On('profile-updated')]
    public function refreshProfile(): void
    {
        $this->user->refresh();
        $this->avatarPath = $this->getAvatarPath();
    }

    protected function getAvatarPath(): string
    {
        return $this->getFileUrl($this->user->avatar) ?? asset('assets/images/no-avatar.png');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.common.navigation.navbar-component');
    }
}
