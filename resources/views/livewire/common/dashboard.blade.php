<div>
    <div class="grid grid-cols-1 content-center">

        <div class="col-span-12">
            <h3 class="text-gray-500">Bem vindo ao sistema!</h3>
            <x-button class="btn-primary" label="Marcar ponto" wire:click="recordTime" />
        </div>

        @if ($welcomeMessage)
        <x-alert icon="o-check" class="alert-success floating-alert">
            {{ $welcomeMessage }}
        </x-alert>
        @endif
    </div>
</div>
