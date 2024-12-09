<div class="mary-card mary-shadow-lg mary-rounded-md mary-p-4">
    <livewire:common.table.header-component :title="$title" :subtitle="$subtitle" :breadcrumbs="$breadcrumbs" />

    <div class="bg-white p-12">
        <x-form wire:submit.prevent="create">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4 row-span-2 flex justify-center items-center">
                    <x-file wire:model="avatar" accept="image/png" crop-after-change>
                        <img src="{{ $avatarPath ?? $defaultAvatar }}" class="rounded-full h-60 w-60 shadow" />
                    </x-file>
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-8 lg:col-span-8 xl:col-span-8">
                    <x-input label="Nome" wire:model="name" error-class="text-red-500 m-1 p-1" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Senha" wire:model="password" error-class="text-red-500 m-1 p-1" type="password" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Confirmação de senha" wire:model="password_confirmation" error-class="text-red-500 m-1 p-1" type="password" />
                </div>
            </div>

            <x-slot:actions>
                <x-button label="Voltar" link="{{ route('dashboard') }}" />
                @if ($item)
                <x-button label="Atualizar" class="btn-primary" wire:click="update" spinner="update" />
                @else
                <x-button label="Salvar" class="btn-primary" wire:click="create" spinner="create" />
                @endif
            </x-slot:actions>
        </x-form>
    </div>
</div>
