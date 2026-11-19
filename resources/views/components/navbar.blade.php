<header class="bg-white border-b border-gray-200">
    <nav class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center gap-2" aria-label="Navigation principale">
        <a href="{{ route('home') }}" class="font-bold text-lg text-indigo-600 mr-4">Mini-CMS</a>

        <x-nav-link to="home">Accueil</x-nav-link>
        <x-nav-link to="posts.index" match="posts.*">Articles</x-nav-link>
        <x-nav-link to="time">Heure</x-nav-link>
        <x-nav-link to="about">À propos</x-nav-link>

        @auth
            <x-nav-link to="posts.create">Nouvel article</x-nav-link>
            <x-nav-link to="posts.mine">Mes articles</x-nav-link>

            @can('manage-categories')
                <x-nav-link to="admin.categories.index">Catégories</x-nav-link>
            @endcan

            @can('manage-tags')
                <x-nav-link to="admin.tags.index" match="admin.tags.*">Tags</x-nav-link>
            @endcan

            <span class="ml-auto text-sm text-gray-600">Connecté : {{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-indigo-600 hover:underline">Déconnexion</button>
            </form>
        @else
            <span class="ml-auto"></span>
            <x-nav-link to="login">Connexion</x-nav-link>
            <x-nav-link to="register">Inscription</x-nav-link>
        @endauth
    </nav>
</header>
