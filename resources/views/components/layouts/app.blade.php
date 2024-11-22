<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Page Title' }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Fontawesome -->
    <script defer src="{{ asset('/vendor/plugins/fontawesome/js/all.js') }}"></script>
    <script defer src="{{ asset('/vendor/plugins/fontawesome/js/fontawesome.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antiliased bg-gray-50 text-sm">
    <!-- Navbar -->
    <livewire:layout.navigation />

    <!-- Sidebar -->
    @persist('sidebar')
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul>
                <li>
                    <a href="{{route('dashboard')}}" wire:navigate
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fa-solid fa-gauge-high w-4 h-4 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-hardware" data-collapse-toggle="dropdown-hardware">
                        <i
                            class="fa-solid fa-microchip flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Hardware</span>
                        <i class="fa-solid fa-chevron-down w-4 h-4"></i>
                    </button>
                    <ul id="dropdown-hardware" class="hidden">
                        <li>
                            <a href="{{route('computers')}}" wire:navigate
                                class="flex items-center p-2 pl-10 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i
                                    class="fa-solid fa-desktop w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ml-3 truncate">Equipos de computo</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                        <i
                            class="fa-solid fa-industry flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Organización</span>
                        <i class="fa-solid fa-chevron-down w-4 h-4"></i>
                    </button>
                    <ul id="dropdown-pages" class="hidden">
                        <li>
                            <a href="{{route('employees')}}" wire:navigate
                                class="flex items-center p-2 pl-10 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i
                                    class="fa-solid fa-people-group w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ml-3">Colaboradores</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('departments')}}" wire:navigate
                                class="flex items-center p-2 pl-10 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i
                                    class="fa-solid fa-sitemap w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ml-3">Departamentos</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
    @endpersist

    <!-- Main content -->
    <main class="p-6 md:ml-64 h-auto pt-20">
        {{ $slot }}
    </main>

    <!-- Masmerise Livewire-Toaster -->
    <x-toaster-hub />

    <!-- WireElements Modal -->
    @livewire('wire-elements-modal')
</body>

</html>