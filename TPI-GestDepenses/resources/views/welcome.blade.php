<!DOCTYPE html>
<html>
<head>
    <title>Gestion Des Depenses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
        <h1 class="text-4xl font-bold mb-8 text-center">Gestion Des Depenses</h1>
        <div class="flex justify-center">
            <a href="{{ url('/home') }}" class="py-4 px-8 bg-blue-500 text-white rounded-full hover:bg-blue-600 mx-2">Dashboard</a>
            <a href="{{ route('login') }}" class="py-4 px-8 bg-gray-500 text-white rounded-full hover:bg-gray-600 mx-2">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="py-4 px-8 bg-gray-500 text-white rounded-full hover:bg-gray-600 mx-2">Register</a>
            @endif
        </div>
    </div>
</body>
</html>
