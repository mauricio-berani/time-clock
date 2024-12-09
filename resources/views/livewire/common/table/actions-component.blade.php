<div class="grid grid-cols-12 gap-4">
    <div class="col-span-12 sm:col-span-12 md:col-span-1 lg:col-span-1 xl:col-span-1" wire:model="searching">
        <x-select
            :options="[['id' => 5, 'name' => 5], ['id' => 10, 'name' => 10], ['id' => 25, 'name' => 25], ['id' => 50, 'name' => 50]]"
            wire:model.live="$parent.perPage" />
    </div>
    <div class="col-span-6 sm:col-span-6 md:col-span-3 lg:col-span-3 xl:col-span-3" wire:model="searching">
        <x-input placeholder="Filtrar" wire:model="search" icon="o-magnifying-glass" @focus="$wire.call('clearSearch')" />
    </div>
    <div class="col-span-6 sm:col-span-6 md:col-span-2 lg:col-span-2 xl:col-span-2" wire:model="searching">
        <x-button icon="o-magnifying-glass" class="btn-circle bg-primary text-white" wire:click="executeSearch" />
        <x-button icon="o-trash" class="btn-circle bg-error text-white" wire:click="clearSearch" />
    </div>

    <div class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-6 text-right">
        <x-button label="{{ __('interface.create_button') }}" class="btn-primary" link="{{ $createRoute }}" />
    </div>
    <div class="col-span-12">
        <div class="divider"></div>
    </div>
</div>
