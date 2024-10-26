<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="h-9 w-auto fill-current text-white inline-block" />
                    </a>
                    <a href="{{ route('home') }}" class="pt-1 pl-2 text-xl font-medium text-white">VRChat Review</a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> --}}
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <div class="text-white">
                            {{ __('Home') }}
                        </div>
                    </x-nav-link>

                    @if (Auth::user())
                        <x-nav-link :href="route('userpage', ['user_id' => Auth::user()->id])" :active="request()->routeIs('userpage', ['user_id' => Auth::user()->id])">
                            <div class="text-white">
                                {{ __('MyPage') }}
                            </div>
                        </x-nav-link>
                    @endif

                    <div class = "inline-flex items-center px-5 text-sm font-medium text-white mr-0">
                        <form action="/worlds/search" method="POST">
                            @csrf
                            <span class ="text-base">
                                Search
                            </span>
                            <input class = "text-gray-600" type="text" name="search[keyword]"
                                placeholder="world name" value="" />
                            <span class ="pl-2 text-base">
                                Sort
                            </span>
                            <select name="search[sort]" class="cursor-pointer text-gray-600">
                                <option value="popularity">popularity</option>
                                {{-- <option value="_created_at">_created_at</option>
                                        <option value="_updated_at">_updated_at</option> --}}
                                <option value="favorites">favorites</option>
                                <option value="heat">heat</option>
                                <option value="trust">trust</option>
                            </select>
                            <label for="switch" class ="pl-2 cursor-pointer">
                                <input type="checkbox" id="switch" name="sortByReview" value="on" />
                                口コミ優先
                            </label><span class ="pl-2 text-gray-600">
                                <input type="submit" value="検索"
                                    class = "inline-block h-10 px-4 items-center justify-center rounded-md border border-gray-200 bg-white hover:bg-gray-100 cursor-pointer active:bg-gray-300 focus:outline-none" />
                            </span>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::user())
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <div>ログイン / 登録</div>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Auth::user())
                            <x-dropdown-link :href="route('userpage', ['user_id' => Auth::user()->id])">
                                {{ __('マイページ') }}
                            </x-dropdown-link>

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
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Login') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if (Auth::user())
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
