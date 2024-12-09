<?php

namespace App\Livewire\Common\Table;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $title;
    public $subtitle;
    public $breadcrumbs;

    public function mount(string $title, string $subtitle, array $breadcrumbs): void
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render(): View
    {
        return view('livewire.common.table.header-component');
    }
}
