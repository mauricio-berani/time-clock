<x-modal wire:model="modal" class="backdrop-blur">
    <div class="my-8">@php echo html_entity_decode($modalText); @endphp</div>
    <div class="row text-right">
        <x-button label="{{ __('interface.cancel_button') }}" class="bg-error text-white" wire:click="closeModal" />
        <x-button label="{{ __('interface.continue_button') }}" class="btn-primary" spinner wire:click="confirmAction" />
    </div>
</x-modal>
