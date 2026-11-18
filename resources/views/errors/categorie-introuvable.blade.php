<x-layout>
    <x-slot:title>Catégorie introuvable - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Catégorie introuvable</h1>
    <p class="mt-2 mb-8 text-gray-600">Cette catégorie n'existe pas ou a été supprimée.</p>

    @if ($categories->isNotEmpty())
        <section class="max-w-2xl" aria-labelledby="categories-title">
            <h2 id="categories-title" class="mb-4 text-xl font-semibold text-gray-900">Catégories disponibles</h2>
            <ul class="list-inside list-disc space-y-2">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('posts.category', ['category' => $category->slug]) }}" class="font-medium text-indigo-600 hover:underline">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @else
        <x-alert type="info" title="Aucune catégorie disponible" class="max-w-2xl">
            Revenez plus tard pour parcourir les catégories.
        </x-alert>
    @endif

    <p class="mt-6">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>
</x-layout>
