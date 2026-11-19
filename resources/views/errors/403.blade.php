<x-layout>
    <x-slot:title>Accès interdit - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Accès interdit</h1>
    <p class="mt-2 mb-8 text-gray-600">Vous n'avez pas les autorisations nécessaires pour accéder à cette page.</p>

    <x-alert type="warning" title="Erreur 403" class="max-w-2xl">
        @if ($exception->getMessage() === 'Réservé aux administrateurs.')
            {{ $exception->getMessage() }}
        @else
            Connectez-vous avec un compte autorisé, ou retournez à l'accueil.
        @endif
    </x-alert>

    <p class="mt-6">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>
</x-layout>
