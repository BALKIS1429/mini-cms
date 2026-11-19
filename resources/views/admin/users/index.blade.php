<x-layout>
    <x-slot:title>Utilisateurs - Mini-CMS</x-slot:title>

    <h1 class="mb-6 text-3xl font-bold">Gestion des utilisateurs</h1>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th scope="col" class="px-4 py-3">Nom</th>
                    <th scope="col" class="px-4 py-3">Adresse e-mail</th>
                    <th scope="col" class="px-4 py-3">Rôle</th>
                    <th scope="col" class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->role }}</td>
                        <td class="px-4 py-3">
                            @if ($user->id === auth()->id())
                                <span class="text-gray-500">Votre compte</span>
                            @else
                                <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <label for="role-{{ $user->id }}" class="sr-only">Rôle de {{ $user->name }}</label>
                                    <select id="role-{{ $user->id }}" name="role" class="rounded-md border border-gray-300 px-2 py-1">
                                        <option value="author" @selected($user->role === 'author')>Auteur</option>
                                        <option value="admin" @selected($user->role === 'admin')>Administrateur</option>
                                    </select>

                                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-1 font-medium text-white hover:bg-indigo-700">
                                        Enregistrer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
