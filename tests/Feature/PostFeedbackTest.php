<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

function feedbackPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article avec message',
        'slug' => 'article-avec-message',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('shows a success message after creating a post', function () {
    $this->followingRedirects()
        ->post(route('posts.store'), feedbackPostData())
        ->assertOk()
        ->assertSee('Article créé.')
        ->assertSee('role="status"', false);

    $this->assertDatabaseHas('posts', ['slug' => 'article-avec-message']);
});

it('shows success messages after updating and publishing a post', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->put(route('posts.update', $post), feedbackPostData([
            'slug' => $post->slug,
            'title' => 'Article modifié',
            'is_published' => '0',
        ]))
        ->assertOk()
        ->assertSee('Article mis à jour.');

    $this->followingRedirects()
        ->patch(route('posts.publication', $post))
        ->assertOk()
        ->assertSee('Article publié.');

    $this->followingRedirects()
        ->patch(route('posts.publication', $post))
        ->assertOk()
        ->assertSee('Article dépublié.');
});

it('shows a success message after deleting a post', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->delete(route('posts.destroy', $post))
        ->assertOk()
        ->assertSee('Article supprimé.');

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('shows the custom page for an unknown post', function () {
    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Article introuvable');
});

it('keeps the standard 404 page for an unknown category', function () {
    $this->get('/posts/categorie/inconnue')
        ->assertNotFound()
        ->assertDontSee('Article introuvable');
});

it('keeps post pages readable and blocks writes in read-only mode', function () {
    config(['site.read_only' => true]);

    $this->get(route('posts.index'))->assertOk();

    $this->post(route('posts.store'), feedbackPostData())
        ->assertServiceUnavailable();
});

it('shows the read-only banner on the home page', function () {
    config(['site.read_only' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Site en lecture seule');
});

it('hides the read-only banner when writes are enabled', function () {
    config(['site.read_only' => false]);

    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Site en lecture seule');
});

it('shows only the three newest published posts on the missing-post page', function () {
    Post::factory()->published()->create([
        'title' => 'Article publié ancien',
        'slug' => 'article-publie-ancien',
        'published_at' => now()->subDays(10),
    ]);

    Post::factory()->published()->create([
        'title' => 'Article récent un',
        'slug' => 'article-recent-un',
        'published_at' => now()->subDays(3),
    ]);

    Post::factory()->published()->create([
        'title' => 'Article récent deux',
        'slug' => 'article-recent-deux',
        'published_at' => now()->subDays(2),
    ]);

    Post::factory()->published()->create([
        'title' => 'Article récent trois',
        'slug' => 'article-recent-trois',
        'published_at' => now()->subDay(),
    ]);

    Post::factory()->create([
        'title' => 'Brouillon récent',
        'slug' => 'brouillon-recent',
    ]);

    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Articles récents')
        ->assertSee('Article récent un')
        ->assertSee('Article récent deux')
        ->assertSee('Article récent trois')
        ->assertDontSee('Article publié ancien')
        ->assertDontSee('Brouillon récent');
});

it('omits the recent-posts section when there are no published posts', function () {
    Post::factory()->create([
        'title' => 'Brouillon seulement',
        'slug' => 'brouillon-seulement',
    ]);

    $this->get('/posts/999')
        ->assertNotFound()
        ->assertDontSee('Articles récents')
        ->assertDontSee('Brouillon seulement');
});
