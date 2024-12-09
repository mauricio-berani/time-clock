<?php

namespace App\Livewire\Common\Table;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActionsComponent extends Component
{
    public $searching;
    public $createRoute;
    public $search;

    public function mount(bool $searching, string $createRoute): void
    {
        $this->searching   = $searching;
        $this->createRoute = $createRoute;
    }

    public function executeSearch(): void
    {
        $this->dispatch('search-updated', $this->search);
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->dispatch('search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.common.table.actions-component');
    }
}
