<?php

namespace App\Livewire\Common\Table;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class NoContentComponent extends Component
{
    public $title;
    public $subtitle;

    public function mount(null|string $title = null, null|string $subtitle = null): void
    {
        $this->title    = $title ?? __('table.no_content_title');
        $this->subtitle = $subtitle ?? __('table.no_content_subtitle');
    }

    public function render(): View
    {
        return view('livewire.common.table.no-content-component');
    }
}
