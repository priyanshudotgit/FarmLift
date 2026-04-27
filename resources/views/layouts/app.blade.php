<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FarmLift | Transport Pooling</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <nav class="bg-green-700 text-white p-4 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">FarmLift</a>
            <div class="space-x-4">
                <a href="#" class="hover:text-green-200">Login</a>
                <a href="#" class="bg-white text-green-700 px-4 py-2 rounded shadow">Register</a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; {{ date('Y') }} FarmLift. Laravel Project.</p>
    </footer>

</body>
</html>