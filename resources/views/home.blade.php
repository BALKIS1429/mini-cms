<x-layout>
    <x-slot:title>Accueil - Mini-CMS</x-slot:title>

    <section class="py-10">
        <h1 class="text-4xl font-bold mb-4">Derniers articles publiés</h1>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($latestPosts as $post)
                <x-post-card :post="$post" />
            @empty
                <p class="text-gray-600">Aucun article publié pour le moment.</p>
            @endforelse
        </div>
    </section>
</x-layout>
