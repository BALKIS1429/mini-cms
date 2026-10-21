
<x-layout>
    <x-slot:title>{{ $post->title }} - Mini-CMS</x-slot:title>

    <article class="max-w-2xl">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:underline">
                Retour aux articles
            </a>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    href="{{ route('posts.edit', $post) }}"
                    class="inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                >
                    Modifier l'article
                </a>

                <form method="POST" action="{{ route('posts.publication', $post) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                        {{ $post->is_published ? 'Dépublier' : 'Publier' }}
                    </button>
                </form>

                <details>
                    <summary class="cursor-pointer rounded-lg border border-red-600 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">
                        Supprimer
                    </summary>

                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="mt-3 rounded-md border border-red-200 bg-red-50 p-4">
                        @csrf
                        @method('DELETE')

                        <p class="mb-3 text-sm text-red-900">Cette action est définitive : l'article sera effacé de la base.</p>
                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Confirmer la suppression</button>
                    </form>
                </details>
            </div>
        </div>

        <h1 class="text-3xl font-bold mt-4 mb-2">{{ $post->title }}</h1>

        @if ($post->excerpt)
            <p class="text-lg text-gray-600 mb-4">{{ $post->excerpt }}</p>
        @endif

        <p class="text-sm text-gray-500 mb-6">
            @if ($post->is_published && $post->published_at)
                Publié le {{ $post->published_at->format('d/m/Y') }}
            @else
                Brouillon
            @endif
        </p>

        <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>
    </article>
</x-layout>
