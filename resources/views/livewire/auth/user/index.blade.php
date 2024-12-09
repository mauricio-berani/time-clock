<div>
    <livewire:common.table.header-component :$title :$subtitle :$breadcrumbs />

    <x-card class="shadow">
        <livewire:common.table.actions-component :$searching wire:model="search" :$createRoute />
        @if($noContent)
        <livewire:common.table.no-content-component />
        @else
        <x-table :headers="$headers" :rows="$this->items" :sort-by="$sortBy" with-pagination>
            @scope('actions', $item)
            <x-button icon="o-pencil" class="btn-primary btn-sm" link="{{ route('users.update', ['user' => $item]) }}" spinner />

            <x-button icon="o-trash" class="btn bg-error text-white btn-sm" wire:click="confirmAction('{{ $item['name'] }}', '{{ $item['id'] }}')" spinner />
            @endscope
        </x-table>
        @endif
    </x-card>

    <livewire:common.action.modal-component />

</div>
