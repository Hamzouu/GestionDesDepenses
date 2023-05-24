<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="max-w-md w-full bg-white rounded p-6 shadow-md">
            <h1 class="text-2xl font-bold text-center mb-5">Ajouter une activité</h1>

            <form action="{{ route('activities.store') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block font-bold text-gray-700">Titre</label>
                    <input type="text" name="title" id="title" class="form-input mt-1 block w-full" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-bold text-gray-700">Description</label>
                    <textarea name="description" id="description" class="form-textarea mt-1 block w-full" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block font-bold text-gray-700">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-select mt-1 block w-full" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="users" class="block font-bold text-gray-700">Utilisateurs</label>
                    <select name="users[]" id="users" class="form-multiselect mt-1 block w-full" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
