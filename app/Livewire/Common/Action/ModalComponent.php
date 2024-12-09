<?php

namespace App\Livewire\Common\Action;

use Livewire\Component;
use Livewire\Attributes\On;

class ModalComponent extends Component
{
    public $modal;
    public $modalText;
    public $action;
    public $selectedItemId;

    #[On('action-required')]
    public function openModal(array $data): void
    {
        $this->modal          = $data['modal'];
        $this->modalText      = $data['modalText'];
        $this->action         = $data['action'];
    }

    public function confirmAction(): void
    {
        $this->dispatch($this->action);
        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.common.action.modal-component');
    }
}
