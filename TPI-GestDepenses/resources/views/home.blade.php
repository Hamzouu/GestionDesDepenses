<x-app-layout>
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="max-w-2xl text-center">
            <h1 class="text-4xl font-bold mb-8">Bienvenue sur mon application de gestion des dépenses</h1>
            <p class="text-lg text-gray-700 mb-4">Mon application vous permet de gérer facilement vos dépenses et de suivre vos finances de manière efficace.</p>
            <p class="text-lg text-gray-700 mb-4">Fonctionnalités principales :</p>
            <ul class="text-lg text-gray-700 list-disc list-inside mb-4">
                <li>Gérez vos dépenses lors de voyages ou evenements</li>
                <li>Créez des catégories pour organiser vos dépenses</li>
                <li>Ajoutez des participants à vos dépenses pour un suivi précis</li>
                <li>Générez des rapports détaillés sur vos dépenses</li>
                <li>Visualisez vos statistiques financières en temps réel</li>
            </ul>
            <a href="{{ route('activities.create') }}" class="py-4 px-8 bg-blue-500 text-white rounded-full hover:bg-blue-600">Accéder à la création d'une activité !</a>
        </div>
    </div>
</x-app-layout>
