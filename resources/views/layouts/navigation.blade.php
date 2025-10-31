<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Left: Logo + Nav --}}
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}"  class="h-14 w-auto"/>
                </a>

                <!-- Dashboard -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                    {{ __('Home') }}
                </x-nav-link>

                <!-- Promotion -->
                <x-nav-link :href="route('promotions.index')" :active="request()->routeIs('promotions.*')" 
                    class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                    {{ __('Promotion') }}
                </x-nav-link>

                <!-- Product -->
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" 
                    class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                    {{ __('Product') }}
                </x-nav-link>

                <!-- My Orders -->
                <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" 
                    class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                    {{ __('My Orders') }}
                </x-nav-link>
            </div>

            {{-- Right: User Menu --}}
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    <!-- Cart Button -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <a href="{{ route('cart.index') }}" 
                           class="relative inline-flex items-center text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                            🛒
                            <span id="cart-count" 
                                  class="absolute -top-2 -right-2 bg-brown-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ session('cart') ? count(session('cart')) : 0 }}
                            </span>
                        </a>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill="currentColor" fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.show')" 
                 class="bg-white text-black hover:bg-gray-100 hover:text-black focus:bg-gray-100 focus:text-black active:bg-gray-100 active:text-black">
    {{ __('Profile') }}
</x-dropdown-link>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <x-dropdown-link :href="route('logout')" 
                     class="bg-white text-black hover:text-black focus:bg-white-100 focus:text-black active:bg-gray-100 active:text-black"
                     onclick="event.preventDefault(); this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form>

                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-sm text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" 
                       class="text-sm text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                        {{ __('Register') }}
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex sm:hidden">
                <button @click="open = ! open" 
                        class="p-2 rounded-md text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div x-show="open" class="sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Promotion -->
            <x-responsive-nav-link :href="route('promotions.index')" :active="request()->routeIs('promotions.*')" 
                class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                {{ __('Promotion') }}
            </x-responsive-nav-link>

            <!-- Product -->
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" 
                class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                {{ __('Product') }}
            </x-responsive-nav-link>

            <!-- My Orders -->
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" 
                class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                {{ __('My Orders') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-[#4A403A] !text-[#4A403A]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#4A403A] !text-[#4A403A]">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show')" 
                                           class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" 
                                               class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1 px-4">
                    <x-responsive-nav-link :href="route('login')" 
                                           class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" 
                                           class="text-[#4A403A] !text-[#4A403A] hover:!text-[#4A403A] focus:!text-[#4A403A] active:!text-[#4A403A]">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav> 
