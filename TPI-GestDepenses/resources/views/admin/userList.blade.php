<x-app-layout>
    <h1>Liste des utilisateurs</h1>

    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</x-app-layout>