<x-menu activate-by-route class="text-white hover:text-white">
    <div class="app-navbar shadow -ml-2 -mt-2 -mr-2 mb-10">
        <div class="flex items-center menu-brand m-auto px-4">
            <img src="/assets/images/logotipo.png" alt="Blib Tech Logo" class="w-20">
        </div>
    </div>
    @foreach ($menus as $menu)
    @if (isset($menu['submenus']))
    <x-menu-sub title="{{ $menu['title'] }}" icon="{{ $menu['icon'] }}">
        @foreach ($menu['submenus'] as $submenu)
        <x-menu-item title="{{ $submenu['title'] }}" icon="c-chevron-right" link="{{ $submenu['link'] }}" />
        @endforeach
    </x-menu-sub>
    @else
    <x-menu-item title="{{ $menu['title'] }}" icon="{{ $menu['icon'] }}" link="{{ $menu['link'] }}" />
    @endif
    @endforeach
</x-menu>
