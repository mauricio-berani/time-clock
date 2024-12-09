<?php

namespace App\Livewire\Common\Navigation;

use App\Enums\Auth\Permissions;
use Livewire\Component;

class SidebarComponent extends Component
{
    public $user;
    public $menus;

    public function mount()
    {
        /** @var \App\Models\Auth\User $user **/
        $this->user = auth()->guard('web')->user();
        $this->menus = [
            [
                'title' => 'Dashboard',
                'link' => route('dashboard'),
                'icon' => 'o-home',
                'permission' => Permissions::MOUNT_DASHBOARD->value,
            ],
            [
                'title' => 'Usuários',
                'icon' => 'o-user-group',
                'link' => route('users.index'),
                'permission' => Permissions::MOUNT_USER->value,
            ],
        ];

        $this->menus = collect($this->menus)->filter(function ($menu) {
            if (isset($menu['submenus'])) {
                $menu['submenus'] = collect($menu['submenus'])->filter(function ($submenu) {
                    return $this->user->can($submenu['permission']);
                })->all();

                return count($menu['submenus']) > 0;
            }

            return $this->user->can($menu['permission']);
        })->all();
    }

    public function render()
    {
        return view('livewire.common.navigation.sidebar-component', [
            'menus' => $this->menus,
        ]);
    }
}
