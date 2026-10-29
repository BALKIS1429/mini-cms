
@props([
    'post' => null,
    'categories',
    'tags',
    'action',
    'method' => 'POST',
    'submitLabel' => 'Enregistrer l’article',
])

@php
    $selectedTags = session()->hasOldInput()
        ? old('tags', [])
        : ($post?->tags->pluck('id')->all() ?? []);
@endphp

<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <div style="margin-bottom: 24px;">
        <label for="title" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
            Titre de l'article
        </label>

        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $post?->title) }}"
            placeholder="Exemple : Mon premier article"
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
            value="{{ old('slug', $post?->slug) }}"
            placeholder="mon-premier-article"
            required
            maxlength="255"
            pattern="[a-z0-9\-]+"
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
        <label for="excerpt" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
            Extrait de l'article
        </label>

        <textarea
            id="excerpt"
            name="excerpt"
            rows="3"
            maxlength="255"
            placeholder="Résumé court de l'article (facultatif)"
            style="display: block; width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; line-height: 1.6; color: #111827; background: #ffffff; resize: vertical;"
        >{{ old('excerpt', $post?->excerpt) }}</textarea>

        @error('excerpt')
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
        >{{ old('body', $post?->body) }}</textarea>

        @error('body')
            <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
        @enderror
    </div>

    <div style="margin-bottom: 24px;">
        <label for="category_id" style="display: block; font-weight: 700; color: #374151; margin-bottom: 8px;">
            Catégorie
        </label>
        <select id="category_id" name="category_id" style="display: block; width: 100%; box-sizing: border-box; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; color: #111827; background: #ffffff;">
            <option value="">Aucune catégorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $post?->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
        @enderror
    </div>

    <fieldset style="margin-bottom: 24px;">
        <legend style="font-weight: 700; color: #374151; margin-bottom: 8px;">Tags</legend>
        <div style="display: flex; flex-wrap: wrap; gap: 16px;">
            @foreach ($tags as $tag)
                <label style="display: flex; align-items: center; gap: 8px; color: #374151; font-size: 14px;">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, $selectedTags))>
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>
        @error('tags')
            <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
        @enderror
        @error('tags.*')
            <p style="color: #dc2626; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
        @enderror
    </fieldset>

    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; margin-bottom: 28px;">
        <label for="is_published" style="display: flex; align-items: center; gap: 12px; color: #374151; font-weight: 600; cursor: pointer;">
            <input type="hidden" name="is_published" value="0">
            <input
                id="is_published"
                name="is_published"
                type="checkbox"
                value="1"
                @checked(old('is_published', $post?->is_published ?? false))
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
            {{ $submitLabel }}
        </button>

        <a
            href="{{ route('posts.index') }}"
            style="display: inline-block; background: #ffffff; color: #374151; padding: 13px 24px; border: 1px solid #d1d5db; border-radius: 10px; text-decoration: none; font-size: 15px; font-weight: 600;"
        >
            Annuler
        </a>
    </div>
</form>
