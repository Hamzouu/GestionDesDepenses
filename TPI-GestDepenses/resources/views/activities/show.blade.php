<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex">
            <div class="w-1/3 bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold mb-4">{{ $activity->title }}</h1>
                <p class="text-gray-500 mb-2">Catégorie: {{ $activity->category->name }}</p>
                <p class="text-gray-500 mb-4">Description: {{ $activity->description }}</p>
                <p class="text-gray-500 mb-4">Créateur: {{ $user->name }}</p>
                <div class="mb-4">
                    <p class="text-gray-500 mb-4">Participants:</p>
                    <ul>
                        @foreach($activity->users as $participant)
                            <li>{{ $participant->name }}</li>
                        @endforeach
                    </ul>
                </div>

                @if(Auth::id() == $activity->user_id || Auth::id() == $activity->super_user_id || auth()->user()->idrole === 1)
                    <a href="{{ route('activities.edit', $activity->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Modifier</a>
                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Supprimer</button>
                    </form>
                @endif
                <a href="{{ route('activities.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mt-4">Mes activités</a>
            </div>
            <div class="w-2/3 ml-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Dépenses</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Nom</th>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Montant</th>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Date</th>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Catégorie</th>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Participants</th>
                            <th class="bg-gray-100 border border-gray-300 px-2 py-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activity->expenses as $expense)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">{{ $expense->title }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $expense->amount }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $expense->created_at }}</td>
                                <td class="border border-gray-300 px-2 py-1">
                                    @if ($expense->category)
                                        {{ $expense->category->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    @foreach($expense->participants as $participant)
                                        {{ $participant->name }} ¦
                                    @endforeach
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    @if(Auth::id() == $activity->user_id || Auth::id() == $activity->super_user_id || auth()->user()->idrole === 1)
                                        <div class="flex">
                                            <a href="{{ route('expenses.edit', ['activity' => $activity->id, 'expense' => $expense->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mr-2">Modifier</a>
                                            <form action="{{ route('expenses.destroy', ['activity' => $activity->id, 'expense' => $expense->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Supprimer</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <a href="{{ route('expenses.create', $activity->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Ajouter une dépense</a>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Récapitulatif des dépenses</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="bg-gray-100 border border-gray-300 px-2 py-1">Participant</th>
                        <th class="bg-gray-100 border border-gray-300 px-2 py-1">Montant dû</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participantsBalances as $participant => $balance)
                        <tr>
                            <td class="border border-gray-300 px-2 py-1">{{ $participant }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $balance }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
