<div class="navbar app-navbar shadow -mt-5 -ml-10 -mr-10 mb-10 bg-white">
    <div class="grid grid-cols-4 gap-4 w-full">
        <div class="col-start-4 justify-self-end">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar indicator">
                    <div class="w-10 rounded-full">
                        <img
                            alt="Avatar do usuário"
                            src="{{ $avatarPath }}" />
                    </div>
                    <span class="mr-2">{{ $user->name }}</span>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('profile') }}"><x-icon name="o-user-circle" label="Perfil" /></a></li>
                    <li wire:click="logout"><x-icon name="o-power" label="Sair" /></li>
                </ul>
            </div>
        </div>
    </div>
</div>
