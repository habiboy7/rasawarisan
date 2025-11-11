<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')

</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 flex flex-col">
    {{-- navbar --}}
    <flux:header container sticky class="bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" />

        <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        {{-- Navbar hanya muncul di desktop --}}
        <flux:navbar class="hidden lg:flex gap-12">
            <flux:dropdown>
                <flux:navbar.item icon:trailing="chevron-down">Destinasi</flux:navbar.item>

                <flux:navmenu>
                    <flux:navmenu.item href="#">Profile</flux:navmenu.item>
                    <flux:navmenu.item href="#">Settings</flux:navmenu.item>
                    <flux:navmenu.item href="#">Billing</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
            <flux:navbar.item href="#">Mitra</flux:navbar.item>
            <flux:navbar.item href="#">ResepAI</flux:navbar.item>
            <flux:navbar.item href="#">Event</flux:navbar.item>
            <flux:navbar.item href="#">Kontak</flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <!-- Login/profile - hanya di desktop -->
        @if (Auth::check())
            <flux:dropdown position="top" align="end" class="me-1.5 max-lg:hidden">
                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @else
            <div class="hidden lg:flex gap-2">
                <flux:button variant="ghost" href="/register">
                    <flux:text color="orange">Daftar</flux:text>
                </flux:button>
                <flux:button variant="primary" color="orange" href="/login">Masuk</flux:button>
            </div>
        @endif

    </flux:header>
    {{-- akhir navbar --}}

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        {{-- Menu navigasi di mobile --}}
        <flux:navlist variant="outline">
            <flux:navlist.group heading="Menu">
                {{-- Destinasi dengan submenu --}}
                <flux:navlist.item icon="map-pin" href="#">
                    Destinasi
                </flux:navlist.item>


                <flux:navlist.item icon="users" href="#">
                    Mitra
                </flux:navlist.item>

                <flux:navlist.item icon="sparkles" href="#">
                    ResepAI
                </flux:navlist.item>

                <flux:navlist.item icon="calendar" href="#">
                    Event
                </flux:navlist.item>

                <flux:navlist.item icon="phone" href="#">
                    Kontak
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        {{-- login/profile di mobile --}}
        @if (Auth::check())
            <flux:navlist variant="outline">
                <flux:navlist.group heading="Akun">
                    <flux:navlist.item icon="user" :href="route('profile.edit')" wire:navigate>
                        {{ auth()->user()->name }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="cog" :href="route('profile.edit')" wire:navigate>
                        {{ __('Settings') }}
                    </flux:navlist.item>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                            {{ __('Log Out') }}
                        </flux:navlist.item>
                    </form>
                </flux:navlist.group>
            </flux:navlist>
        @else
            <div class="flex flex-col gap-2 px-4 pb-4">
                <flux:button variant="subtle" href="/register" class="w-full">Daftar</flux:button>
                <flux:button variant="primary" color="orange" href="/login" class="w-full">Masuk</flux:button>
            </div>
        @endif
    </flux:sidebar>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
    @fluxScripts
</body>

</html>
