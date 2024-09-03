<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="{{ str_replace('_', '-', app()->getLocale()) }}sai">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    <!-- Font -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-sm">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="https://dipak.com.mx" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            <x-application-logo-lg class="h-20"></x-application-logo-lg>
        </a>
        <div class="w-full bg-white rounded-xl border border-gray-200 md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Bienvenido, por favor inicie sesion.
                </h1>
                <form action="{{route('login')}}" method="POST" class="space-y-4 md:space-y-6">
                    @csrf
                    <div>
                        <x-forms.label for="email">Correo electronico:</x-forms.label>
                        <x-forms.input id="email" name="email" type="email" placeholder="Correo electronico" required/>
                    </div>
                    <div>
                        <x-forms.label for="password">Contraseña:</x-forms.label>
                        <x-forms.input id="password" name="password" type="password" placeholder="Contraseña" required/>
                    </div>
                    <x-buttons.primary class="w-full py-2.5">Iniciar sesión</x-buttons.primary>
                </form>
            </div>
        </div>
    </div>
 </body>
</html>