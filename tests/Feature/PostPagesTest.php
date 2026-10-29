<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home displays only the three latest published posts', function () {
    Post::factory()->create([
        'title' => 'Ancien article publie',
        'slug' => 'ancien-article-publie',
        'is_published' => true,
        'published_at' => now()->subDays(4),
    ]);

    $secondPost = Post::factory()->create([
        'title' => 'Deuxieme article publie',
        'slug' => 'deuxieme-article-publie',
        'is_published' => true,
        'published_at' => now()->subDays(2),
    ]);

    $thirdPost = Post::factory()->create([
        'title' => 'Troisieme article publie',
        'slug' => 'troisieme-article-publie',
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    $latestPost = Post::factory()->create([
        'title' => 'Article publie le plus recent',
        'slug' => 'article-publie-plus-recent',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $draftPost = Post::factory()->create([
        'title' => 'Brouillon pour le test',
        'slug' => 'brouillon-test',
        'is_published' => false,
        'published_at' => null,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Derniers articles publiés');
    $response->assertSee($latestPost->title);
    $response->assertSee($thirdPost->title);
    $response->assertSee($secondPost->title);
    $response->assertDontSee('Ancien article publie');
    $response->assertDontSee($draftPost->title);
});

test('edit form submits the title to the update route', function () {
    $post = Post::factory()->create([
        'title' => 'Titre initial',
        'slug' => 'titre-initial',
    ]);

    $response = $this->get(route('posts.edit', $post));

    $response->assertOk();
    $response->assertSee('name="title"', false);
    $response->assertSee('value="Titre initial"', false);
    $response->assertSee('value="PUT"', false);
    $response->assertSee('pattern="[a-z0-9\\-]+"', false);
});

test('post can be updated through the HTTP route including its title', function () {
    $post = Post::factory()->create([
        'title' => 'Titre avant modification',
        'slug' => 'titre-avant-modification',
        'excerpt' => 'Ancien résumé',
        'body' => 'Ancien contenu de longueur suffisante pour passer la validation.',
    ]);

    $response = $this->post(route('posts.update', $post), [
        '_method' => 'PUT',
        'title' => 'Titre après modification',
        'slug' => $post->slug,
        'excerpt' => 'Résumé modifié',
        'body' => 'Nouveau contenu de longueur suffisante pour passer la validation.',
        'is_published' => '1',
    ]);

    $response->assertRedirect(route('posts.show', $post));
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Titre après modification',
        'excerpt' => 'Résumé modifié',
        'body' => 'Nouveau contenu de longueur suffisante pour passer la validation.',
    ]);
});

test('post update rejects a slug already used by another post', function () {
    $post = Post::factory()->create([
        'title' => 'Article à conserver',
        'slug' => 'article-a-conserver',
    ]);

    $otherPost = Post::factory()->create([
        'slug' => 'slug-deja-utilise',
    ]);

    $response = $this->put(route('posts.update', $post), [
        'title' => 'Titre proposé',
        'slug' => $otherPost->slug,
        'excerpt' => null,
        'body' => 'Contenu suffisamment long pour passer la validation.',
    ]);

    $response->assertSessionHasErrors('slug');
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Article à conserver',
        'slug' => 'article-a-conserver',
    ]);
});

test('post can be created as a draft without an excerpt', function () {
    $response = $this->post(route('posts.store'), [
        'title' => 'Nouveau brouillon',
        'slug' => 'nouveau-brouillon',
        'body' => 'Contenu suffisamment long pour créer un article brouillon.',
    ]);

    $post = Post::where('slug', 'nouveau-brouillon')->firstOrFail();

    $response->assertRedirect(route('posts.show', $post));
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'excerpt' => null,
        'is_published' => false,
        'published_at' => null,
    ]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee('Nouveau brouillon')
        ->assertSee('Brouillon')
        ->assertSee('Publier')
        ->assertSee('Supprimer')
        ->assertSee('name="_method" value="PATCH"', false)
        ->assertSee('name="_method" value="DELETE"', false);
});

test('posts are paginated four per page', function () {
    foreach (range(1, 5) as $number) {
        Post::factory()->create([
            'title' => "Article {$number}",
            'slug' => "article-{$number}",
        ]);
    }

    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Article 5')
        ->assertSee('Article 2')
        ->assertDontSee('Article 1');

    $this->get(route('posts.index', ['page' => 2]))
        ->assertOk()
        ->assertSee('Article 1')
        ->assertDontSee('Article 5');
});

test('archive shows posts published in the requested year', function () {
    Post::factory()->published()->create([
        'title' => 'Archive 2025',
        'slug' => 'archive-2025',
        'published_at' => '2025-06-14 12:00:00',
    ]);

    Post::factory()->published()->create([
        'title' => 'Archive 2024',
        'slug' => 'archive-2024',
        'published_at' => '2024-06-14 12:00:00',
    ]);

    Post::factory()->create([
        'title' => 'Brouillon archive 2025',
        'slug' => 'brouillon-archive-2025',
        'is_published' => false,
        'published_at' => '2025-06-14 12:00:00',
    ]);

    $this->get(route('posts.archive', 2025))
        ->assertOk()
        ->assertSee('Archive 2025')
        ->assertDontSee('Archive 2024')
        ->assertDontSee('Brouillon archive 2025');
});
