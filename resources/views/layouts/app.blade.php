<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Page Title' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    <!-- Font -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Fontawesome -->
    <script defer src="{{ asset('/vendor/plugins/fontawesome/js/all.js') }}"></script>
    <script defer src="{{ asset('/vendor/plugins/fontawesome/js/fontawesome.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-sm">
    <!-- Navbar -->
    <nav class="bg-white border border-gray-200 px-4 py-3 fixed left-0 right-0 top-0 z-50">
        <div class="grid grid-cols-3">
            <div class="flex items-center justify-start">
                <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Toggle sidebar</span>
                </button>
                <div class="hidden md:block">
                    <a href="https://dipak.com.mx" class="flex items-center">
                        <x-application-logo-sm class="h-8 mr-3" />
                        <span class="self-center text-lg font-semibold">Asset Manager <span
                                class="font-normal">Dipak</span></span>
                    </a>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="md:hidden">
                    <x-application-logo-sm class="h-8" />
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="flex items-center justify-end">
                    <button type="button" class="flex mr-2 rounded-full md:mr-0" id="user-menu-button"
                        aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full ring-1 ring-primary-700">
                            <span class="font-medium text-gray-600 dark:text-gray-300">{{Auth::user()->initials}}</span>
                        </div>
                        <span class="self-center text-sm font-medium ml-3 hidden md:block">{{Auth::user()->name}}</span>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown">
                        <div class="py-3 px-4 md:hidden">
                            <span
                                class="block text-sm font-medium text-gray-900 dark:text-white">{{Auth::user()->name}}</span>
                            <span
                                class="block text-sm text-gray-900 truncate dark:text-white">{{Auth::user()->email}}</span>
                        </div>
                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <a href="{{route('logout')}}"
                                        class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-4 h-4 text-red-400"></i>
                                        Cerrar sesión
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
        aria-label="Sidenav" id="drawer-navigation">
        <div class=" overflow-y-auto px-3 h-full bg-white">
            <ul class="space-y-1">
                <li>
                    <a href="{{route('dashboard')}}"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i
                            class="fa-solid fa-gauge-high w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-hardware" data-collapse-toggle="dropdown-hardware">
                        <i
                            class="fa-solid fa-microchip flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Hardware</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-hardware" class="hidden">
                        <li>
                            <a href=""
                                class="flex items-center p-2 pl-11 w-full text-sm font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <i class="fa-solid fa-people-group w-4 h-4"></i>
                                <span class="ml-3">Equipos de computo</span>
                            </a>
                        </li>
                        <li>
                            <a href=""
                                class="flex items-center p-2 pl-11 w-full text-sm font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <i class="fa-solid fa-mobile-retro w-4 h-4"></i>
                                <span class="ml-3">Handhelds</span>
                            </a>
                        </li>
                        <li>
                            <a href=""
                                class="flex items-center p-2 pl-11 w-full text-sm font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <i class="fa-solid fa-tablet w-4 h-4"></i>
                                <span class="ml-3">Tablets</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                        <i
                            class="fa-solid fa-industry flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Organización</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-pages" class="hidden">
                        <li>
                            <a href=""
                                class="flex items-center p-2 pl-11 w-full text-sm font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <i class="fa-solid fa-people-group w-4 h-4"></i>
                                <span class="ml-3">Colaboradores</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('departments')}}"
                                class="flex items-center p-2 pl-11 w-full text-sm font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <i class="fa-solid fa-sitemap w-4 h-4"></i>
                                <span class="ml-3">Departamentos</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Page content -->
    <main class="px-6 md:ml-64 h-auto pt-20 pb-4">
        {{ $slot }}
    </main>
</body>

</html>