<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('laratrust.roles.index')" :active="request()->routeIs('laratrust.roles.index')">
                        {{ __('Roles') }}
                    </x-nav-link>
                    <x-nav-link :href="route('laratrust.permissions.index')" :active="request()->routeIs('laratrust.permissions.index')">
                        {{ __('Permissions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('laratrust.roles-assignment.index')" :active="request()->routeIs('laratrust.roles-assignment.index')">
                        {{ __('Roles & Permissions Assignment') }}
                    </x-nav-link>
                    <x-nav-link :href="route('laratrust.projects')" :active="request()->routeIs('laratrust.projects')">
                        {{ __('Projects') }}
                    </x-nav-link>
                    <x-nav-link :href="route('laratrust.issues')" :active="request()->routeIs('laratrust.issues')">
                        {{ __('Issues') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                             class="text-red-500 hover:text-red-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="md:hidden absolute top-16 left-0 right-0 z-50 bg-white shadow-lg mx-4 rounded-lg border">
        <!-- User Info -->
        <div class="px-4 pt-6 pb-2">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" class="border-b">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                                       onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                       class="text-red-500 hover:text-red-700">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laratrust.roles.index')" :active="request()->routeIs('laratrust.roles.index')">
                {{ __('Roles') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laratrust.permissions.index')" :active="request()->routeIs('laratrust.permissions.index')">
                {{ __('Permissions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laratrust.roles-assignment.index')" :active="request()->routeIs('laratrust.roles-assignment.index')">
                {{ __('Roles & Permissions Assignment') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laratrust.projects')" :active="request()->routeIs('laratrust.projects')">
                {{ __('Projects') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laratrust.issues')" :active="request()->routeIs('laratrust.issues')">
                {{ __('Issues') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
