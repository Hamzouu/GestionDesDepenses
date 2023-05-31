<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="w-full bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Create Expense</h1>
            <!-- Formulaire pour créer une dépense -->
            <form action="{{ route('expenses.store', $activity) }}" method="POST">
                @csrf
                <!-- Champs de formulaire pour la création d'une dépense -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="form-input w-full">
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-input w-full">
                </div>
                <div class="mb-4">
                    <label for="created_at" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="created_at" id="created_at" class="form-input w-full">
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" id="category" class="form-select w-full">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="form-textarea w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label for="users" class="block text-sm font-medium text-gray-700">Utilisateurs</label>
                    <select name="users[]" id="users" class="form-select w-full" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- ... autres champs de formulaire si nécessaire -->

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Create Expense</button>
            </form>
        </div>
    </div>
</x-app-layout>
