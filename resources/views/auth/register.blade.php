<x-layout>
    <x-slot:title>Inscription - Mini-CMS</x-slot:title>

    <section class="mx-auto max-w-xl">
        <h1 class="mb-6 text-3xl font-bold">Créer un compte</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Nom</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Adresse e-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Mot de passe</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirmer le mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
            </div>

            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">
                S'inscrire
            </button>
        </form>
    </section>
</x-layout>
