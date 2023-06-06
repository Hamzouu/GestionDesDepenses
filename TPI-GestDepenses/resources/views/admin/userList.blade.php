<x-app-layout>
    <x-slot name="title">
        Liste des utilisateurs
    </x-slot>

    <div class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-4">Liste des utilisateurs</h2>

            <!-- Afficher les options de filtrage -->
            <form action="{{ route('admin.userList') }}" method="GET" class="mb-4">
                <div class="flex items-center">
                    <label for="approved" class="mr-2">Filtrer par statut d'approbation :</label>
                    <select name="approved" id="approved" class="border border-gray-300 rounded-md py-1 px-2">
                        <option value="">Tous</option>
                        <option value="approved" {{ $selectedFilter === 'approved' ? 'selected' : '' }}>Approuvés</option>
                        <option value="not_approved" {{ $selectedFilter === 'not_approved' ? 'selected' : '' }}>Non approuvés</option>
                    </select>
                    <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrer</button>
                </div>
            </form>

            <!-- Afficher la liste des utilisateurs -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut d'approbation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->approved ? 'Approuvé' : 'Non approuvé' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (!$user->approved)
                                        <form action="{{ route('admin.approveUser', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approuver</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
