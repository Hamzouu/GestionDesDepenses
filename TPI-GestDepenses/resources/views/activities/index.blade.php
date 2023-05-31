<x-app-layout>
    <x-slot name="title">
        Liste des activités
    </x-slot>

    <div class="flex flex-col items-center bg-white py-8">
        <h2 class="text-2xl font-bold mb-4">Liste des activités</h2>
        
        <div class="mb-4">
            <div class="flex justify-center">
                <a href="{{ route('activities.index') }}" class="mr-4 @if(empty(request()->segment(3))) font-bold @endif">Toutes les activités</a>
                @foreach($categories as $category)
                    <a href="{{ route('activities.filterByCategory', $category) }}" class="mr-4 @if(request()->segment(3) == $category->id) font-bold @endif">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="flex justify-center mt-4">
                <a href="{{ route('activities.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter une activité</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            @foreach($activities as $activity)
                @if($activity->user_id === Auth::id() || $activity->participants->contains('id', Auth::id()))
                    <div class="border border-gray-300 p-4 flex flex-col">
                        <h3 class="text-lg font-bold">{{ $activity->title }}</h3>
                        <p class="text-gray-500">{{ $activity->category->name }}</p>
                        <div class="flex-grow mt-2">{{ $activity->description }}</div>
                        <div class="mt-4">
                            <a href="{{ route('activities.show', $activity->id) }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">Voir activité</a>
                            @if($activity->user_id === Auth::id())
                                <a href="{{ route('activities.edit', $activity->id) }}" class="inline-block bg-green-500 text-white py-2 px-4 rounded"> Modifier </a>
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
