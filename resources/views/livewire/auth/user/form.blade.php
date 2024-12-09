<div class="mary-card mary-shadow-lg mary-rounded-md mary-p-4">
    <livewire:common.table.header-component :$title :$subtitle :$breadcrumbs />

    <div class="bg-white p-12">
        <x-form wire:submit.prevent="create">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Nome" wire:model="name" error-class="text-red-500 m-1 p-1" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="E-mail" wire:model="email" error-class="text-red-500 m-1 p-1" />
                </div>

                <div class="hidden md:block md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-select label="Função" :options="$roleOptions" option-value="value" option-label="label" placeholder="Selecione a função" wire:model="user_role" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input
                        label="CPF"
                        wire:model="document"
                        error-class="text-red-500 m-1 p-1"
                        type="text"
                        maxlength="14"
                        oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Cargo" wire:model="job_title" error-class="text-red-500 m-1 p-1" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-datetime
                        label="Data de nascimento"
                        wire:model="birthday"
                        icon="o-calendar" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Senha" wire:model="password" error-class="text-red-500 m-1 p-1" type="password" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Confirmação de senha" wire:model="password_confirmation" error-class="text-red-500 m-1 p-1" type="password" />
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="CEP" wire:model.defer="zip_code" oninput="this.value = this.value.replace(/\D/g, '')" maxlength="8" wire:change="fetchAddress" />
                    @error('zip_code') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Estado" wire:model.defer="state" />
                    @error('state') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Cidade" wire:model.defer="city" />
                    @error('city') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Bairro" wire:model.defer="neighborhood" />
                    @error('neighborhood') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Rua" wire:model.defer="street" />
                    @error('street') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Número" wire:model.defer="number" />
                    @error('number') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4">
                    <x-input label="Complemento" wire:model.defer="complement" />
                    @error('complement') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <x-slot:actions>
                <x-button label="{{ __('interface.back_button') }}" link="{{ route('users.index') }}" />
                @if ($item)
                <x-button label="{{ __('interface.update_button') }}" class="btn-primary" wire:click="update" spinner="update" />
                @else
                <x-button label="{{ __('interface.create_button') }}" class="btn-primary" wire:click="create" spinner="create" />
                @endif
            </x-slot:actions>
        </x-form>

        @if (isset($timeRecords) && $timeRecords->isNotEmpty())
        <div class="mt-8">
            <h3 class="text-lg font-bold mb-4">{{ __('interface.time_records') }}</h3>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">{{ __('interface.date') }}</th>
                        <th class="border border-gray-300 px-4 py-2">{{ __('interface.time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timeRecords as $record)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->recorded_at->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->recorded_at->format('H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $timeRecords->links() }}
            </div>
        </div>
        @endif

    </div>
</div>
