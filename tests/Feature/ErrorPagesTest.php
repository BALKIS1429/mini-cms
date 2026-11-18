<?php

use App\Models\Category;

beforeEach(function () {
    $this->withoutVite();
});

it('shows the styled 404 page for an unknown URL', function () {
    $this->get('/page-inexistante')
        ->assertNotFound()
        ->assertSee('Page introuvable')
        ->assertSee("Retour à l'accueil", false)
        ->assertSee('Navigation principale');
});

it('shows the styled 503 page when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->post(route('admin.categories.store'), [])
        ->assertServiceUnavailable()
        ->assertSee('Service momentanément indisponible')
        ->assertSee('Le site est en lecture seule.')
        ->assertSee("Retour à l'accueil", false);
});

it('shows available categories on an unknown category page and preserves JSON errors', function () {
    $category = Category::factory()->create(['name' => 'Cuisine', 'slug' => 'cuisine']);
    Category::factory()->create(['name' => 'PHP', 'slug' => 'php']);

    $this->get(route('posts.category', ['category' => 'inconnue']))
        ->assertNotFound()
        ->assertSee('Catégorie introuvable')
        ->assertSee('Cuisine')
        ->assertSee('PHP')
        ->assertSee(route('posts.category', ['category' => $category->slug]));

    $this->getJson(route('posts.category', ['category' => 'inconnue']))
        ->assertNotFound()
        ->assertJsonStructure(['message']);

    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Article introuvable');
});
