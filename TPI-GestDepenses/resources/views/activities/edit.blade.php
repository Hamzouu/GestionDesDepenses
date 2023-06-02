<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="w-full bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Modifier l'activité</h1>

            <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                    <input type="text" name="title" id="title" value="{{ $activity->title }}" class="form-input w-full">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="form-textarea w-full">{{ $activity->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-select w-full">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $activity->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="users" class="block text-sm font-medium text-gray-700">Participants</label>
                    @foreach($users as $user)
                        <div>
                            <input type="checkbox" id="user_{{ $user->id }}" name="users[]" value="{{ $user->id }}" {{ in_array($user->id, $activity->users->pluck('id')->toArray()) ? 'checked disabled' : '' }}>
                            <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                        </div>
                    @endforeach
                </div>




                <div class="flex justify-end">
                    <a href="{{ route('activities.show', $activity->id) }}" class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded">Annuler</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
