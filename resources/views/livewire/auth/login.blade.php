<div class="flex flex-wrap h-screen">
    <div class="h-full w-1/2 p-4 shadow-md hidden md:block bg-login-background"></div>
    <div class="h-full md:w-1/2 p-4 shadow-md h-screen w-screen flex items-center justify-center bg-base-300">
        <div class=" p-20">
            <figure class="w-full my-4">
                <img src="/assets/images/logotipo.png" alt="Blib" class="items-center w-32 m-auto">
            </figure>
            <x-form wire:submit.prevent="login">

                <div>
                    <x-input label="E-mail" wire:model="email" class="mb-4 w-80" type="email" />
                </div>

                <div>
                    <x-input label="Senha" wire:model="password" class="mb-4 w-80" type="password" />
                </div>

                <x-slot:actions>
                    <x-button label="Entrar" class="btn-primary mb-4 w-80" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </div>
    </div>
</div>
