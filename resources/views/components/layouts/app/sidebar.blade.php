<?php

    $groups = [
        'Platform' => [
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'url'  => route('dashboard'),
                'current' => request()->routeIs('dashboard')
            ],
            [
                'name' => 'Clientes',
                'icon' => 'users',
                'url'  => route('admin.clients.index'),
                'current' => request()->routeIs('clients.*')
            ],
            [
                'name' => 'Suplementos',
                'icon' => 'beaker',
                'url'  => route('admin.brands.index'),
                'current' => request()->routeIs('brands.*')
            ],
        ],
    ];

    $sistems = [
        'Sistema' => [
            [
                'name' => 'Gym',
                'icon' => 'building-storefront',
                'url'  => route('admin.gyms.index'),
                'current' => request()->routeIs('gyms.*')
            ],
            [
                'name' => 'Categorias',
                'icon' => 'wrench-screwdriver',
                'url'  => route('admin.categories.index'),
                'current' => request()->routeIs('categories.*')
            ],
            [
                'name' => 'Entrenadores',
                'icon' => 'users',
                'url'  => route('admin.coaches.index'),
                'current' => request()->routeIs('coaches.*')
            ],
            [
                'name' => 'Horarios',
                'icon' => 'clock',
                'url'  => route('admin.category_schedules.index'),
                'current' => request()->routeIs('category_schedules.*')
            ],
            [
                'name' => 'Marca',
                'icon' => 'clipboard-document-list',
                'url'  => route('admin.brands.index'),
                'current' => request()->routeIs('brands.*')
            ],
            [
                'name' => 'Tipos de Productos',
                'icon' => 'clipboard-document-list',
                'url'  => route('admin.category_schedules.index'),
                'current' => request()->routeIs('category_schedules.*')
            ],
        ],
    ];


?>



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                @foreach ($groups as $group => $links)

                    <flux:navlist.group :heading="$group" class="grid">

                        @foreach ($links as $link)
                            <flux:navlist.item class="mb-4" :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>{{ $link['name'] }}</flux:navlist.item>
                        @endforeach

                    </flux:navlist.group>
                    
                @endforeach
            </flux:navlist>

            <flux:navlist.group heading="Config" class="grid">
                <flux:navlist.group variant="outline" heading="Sistema" expandable :expanded="false">
                    @foreach ($sistems as $sistem => $links)
                        <flux:navlist.group class="grid mb-2 mt-2 cursor-pointer">
                            @foreach ($links as $link)
                                <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>{{ $link['name'] }}</flux:navlist.item>
                            @endforeach
                        </flux:navlist.group>
                    @endforeach
                    
                </flux:navlist.group>
            </flux:navlist.group>





            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts

        

        
        <script>
            forms = document.querySelectorAll('.delete-form');

            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    Swal.fire({
                        title: "Estas Seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Eliminarlo!",
                        cancelButtonText: "Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                        });

                });
            });
        </script>
        
    </body>
</html>
