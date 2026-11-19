<x-layout>
    <x-slot:title>Connexion - Mini-CMS</x-slot:title>

    <section class="mx-auto max-w-xl">
        <h1 class="mb-6 text-3xl font-bold">Connexion</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Adresse e-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Mot de passe</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input name="remember" type="checkbox" value="1" @checked(old('remember'))>
                Se souvenir de moi
            </label>

            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">
                Se connecter
            </button>
        </form>
    </section>
</x-layout>
