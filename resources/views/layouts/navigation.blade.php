<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white">
                        Review Me
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('businesses.index')" :active="request()->routeIs('businesses.*')" class="text-white hover:text-gray-300 hover:border-gray-300">
                        {{ __('Businesses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-white hover:text-gray-300 hover:border-gray-300">
                        {{ __('Categories') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-100 hover:text-white mr-4">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-white text-indigo-700 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-100 focus:bg-white active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition ease-in-out duration-150">Register</a>
                @else
                    <a href="{{ route('businesses.create') }}" class="mr-4 px-4 py-2 bg-white text-indigo-700 rounded-md hover:bg-gray-100 shadow-sm">
                        Add Business
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition ease-in-out duration-150">
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
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('businesses.index')" :active="request()->routeIs('businesses.*')" class="text-white">
                {{ __('Businesses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-white">
                {{ __('Categories') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-indigo-800">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-indigo-200">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('businesses.create') }}" class="block w-full px-4 py-2 text-base font-medium text-indigo-700 bg-white hover:bg-gray-50 text-center rounded-md shadow-sm">
                        Add Business
                    </a>
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="text-white">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-indigo-800">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="text-white">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="text-white">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
