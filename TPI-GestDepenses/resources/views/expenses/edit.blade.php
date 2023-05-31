<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="w-full bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Modifier la dépense</h1>
            <form action="{{ route('expenses.update', ['activity' => $activity->id, 'expense' => $expense->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="title" id="title" value="{{ $expense->title }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Montant</label>
                <input type="number" name="amount" id="amount" value="{{ $expense->amount }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="form-textarea w-full">{{ $expense->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                <select name="category" id="category" class="form-select w-full">
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('activities.show', ['activity' => $activity->id, 'expense' => $expense->id]) }}" class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded">Annuler</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>