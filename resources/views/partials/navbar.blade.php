<nav x-data="{menuOpen: false}" class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button x-on:click="menuOpen = !menuOpen" type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-primary-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <template x-if="!menuOpen">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </template>
                    <template x-if="menuOpen">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </template>

                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <img class="block h-8 w-auto lg:hidden" src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="Your Company">
                    <img class="hidden h-8 w-auto lg:block" src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="Your Company">
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="{{ route('projects') }}" class="px-3 py-2 rounded-md text-sm font-medium @if(request()->routeIs('projects')) bg-primary-600 text-white @else text-gray-700 hover:bg-primary-500 hover:text-white @endif" aria-current="page">Projects</a>

                        <a href="{{ route('invitations') }}" class="px-3 py-2 rounded-md text-sm font-medium @if(request()->routeIs('invitations')) bg-primary-600 text-white @else text-gray-700 hover:bg-primary-500 hover:text-white @endif">Invitations</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Profile dropdown -->
                <div x-data="{open: false}" class="relative ml-3">
                    <div>
                        <button x-on:click="open = !open" type="button" class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </button>
                    </div>

                    <div
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        x-cloak
                    >
                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <template x-if="menuOpen">
        <div class="sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <a href="{{ route('projects') }}" class="block px-3 py-2 rounded-md text-base font-medium @if(request()->routeIs('projects')) bg-primary-600 text-white @else text-gray-700 hover:bg-primary-500 hover:text-white @endif" aria-current="page">Projects</a>

                <a href="{{ route('invitations') }}" class="block px-3 py-2 rounded-md text-base font-medium @if(request()->routeIs('invitations')) bg-primary-600 text-white @else text-gray-700 hover:bg-primary-500 hover:text-white @endif">Invitations</a>
            </div>
        </div>
    </template>
</nav>
