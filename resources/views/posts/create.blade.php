
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

            <x-post-form
                :action="route('posts.store')"
                submit-label="Enregistrer l'article"
            />

        </div>

        <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 20px;">
            Mini-CMS — Gestion des articles
        </p>

    </div>
</x-layout>
