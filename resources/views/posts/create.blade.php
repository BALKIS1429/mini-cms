<x-layout>
    <x-slot:title>Nouvel article - Mini-CMS</x-slot:title>

    <div style="max-width: 900px; margin: 40px auto; padding: 0 20px;">

        <div style="margin-bottom: 30px;">
            <p style="color: #4f46e5; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                Mini-CMS / Articles
            </p>

            <h1 style="font-size: 32px; font-weight: 800; color: #111827; margin: 10px 0;">
                Créer un nouvel article
            </h1>

            <p style="color: #6b7280; font-size: 16px;">
                Remplissez les informations ci-dessous pour ajouter un article.
            </p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">

            <form action="{{ route('posts.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 24px;">
                    <label for="title" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
                        Titre de l'article
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title') }}"
                        placeholder="Exemple : Mon premier article"
                        required
                        maxlength="255"
                        style="display: block; width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; color: #111827; background: #ffffff;"
                    >

                    @error('title')
                        <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="slug" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
                        Slug
                    </label>

                    <input
                        id="slug"
                        name="slug"
                        type="text"
                        value="{{ old('slug') }}"
                        placeholder="mon-premier-article"
                        required
                        maxlength="255"
                        pattern="[a-z0-9-]+"
                        style="display: block; width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; color: #111827; background: #ffffff;"
                    >

                    <p style="font-size: 13px; color: #6b7280; margin-top: 6px;">
                        Utilisez uniquement des lettres minuscules, des chiffres et des tirets.
                    </p>

                    @error('slug')
                        <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="body" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
                        Contenu de l'article
                    </label>

                    <textarea
                        id="body"
                        name="body"
                        rows="8"
                        placeholder="Écrivez le contenu de votre article..."
                        required
                        minlength="20"
                        style="display: block; width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; line-height: 1.6; color: #111827; background: #ffffff; resize: vertical;"
                    >{{ old('body') }}</textarea>

                    @error('body')
                        <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; margin-bottom: 28px;">
                    <label for="is_published" style="display: flex; align-items: center; gap: 12px; color: #374151; font-weight: 600; cursor: pointer;">
                        <input
                            id="is_published"
                            name="is_published"
                            type="checkbox"
                            value="1"
                            @checked(old('is_published'))
                            style="width: 18px; height: 18px; accent-color: #4f46e5;"
                        >
                        Publier immédiatement
                    </label>

                    <p style="font-size: 13px; color: #6b7280; margin: 8px 0 0 30px;">
                        Cochez cette option pour publier l'article dès son enregistrement.
                    </p>
                </div>

                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; border-top: 1px solid #e5e7eb; padding-top: 24px;">
                    <button
                        type="submit"
                        style="background: #4f46e5; color: #ffffff; padding: 14px 24px; border: none; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: 700;"
                    >
                        Enregistrer l'article
                    </button>

                    <a
                        href="{{ route('posts.index') }}"
                        style="display: inline-block; background: #ffffff; color: #374151; padding: 13px 24px; border: 1px solid #d1d5db; border-radius: 10px; text-decoration: none; font-size: 15px; font-weight: 600;"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 20px;">
            Mini-CMS — Gestion des articles
        </p>

    </div>
</x-layout>
