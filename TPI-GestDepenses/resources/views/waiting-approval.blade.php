<!DOCTYPE html>
<html>
<head>
    <title>En attente d'approbation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl mb-8">Attente d'approbation d'un administrateur...</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Se déconnecter</button>
        </form>
    </div>
</body>
</html>
