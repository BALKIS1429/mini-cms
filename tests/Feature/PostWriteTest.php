<?php

use App\Models\Post;

function postWriteData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '0',
        'published_at' => null,
    ], $overrides);
}

it('creates a post from the form', function () {
    $this->post(route('posts.store'), postWriteData())
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
        'is_published' => false,
        'published_at' => null,
    ]);
});

it('does not create a post without a title', function () {
    $this->from(route('posts.create'))
        ->post(route('posts.store'), postWriteData(['title' => '']))
        ->assertRedirect(route('posts.create'))
        ->assertSessionHasErrors('title')
        ->assertSessionHasInput('is_published', '0');

    $this->assertDatabaseMissing('posts', ['slug' => 'article-de-test']);

    $this->get(route('posts.create'))
        ->assertOk()
        ->assertDontSee('value="1" checked', false);
});

it('shows the edit form with the current values', function () {
    $post = Post::factory()->create(postWriteData([
        'title' => 'Titre initial',
        'slug' => 'titre-initial',
    ]));

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertSee('Titre initial')
        ->assertSee('Un extrait court.')
        ->assertSee('name="is_published" value="0"', false);
});

it('updates a post and keeps its own slug', function () {
    $post = Post::factory()->create(postWriteData());

    $this->put(route('posts.update', $post), postWriteData([
        'title' => 'Titre modifié',
    ]))->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Titre modifié',
        'slug' => 'article-de-test',
    ]);
});

it('preserves the unchecked publication state after a title validation error', function () {
    $post = Post::factory()->create(postWriteData([
        'title' => 'Article publié',
        'slug' => 'article-publie',
        'is_published' => true,
        'published_at' => now(),
    ]));

    $this->from(route('posts.edit', $post))
        ->put(route('posts.update', $post), postWriteData([
            'title' => '',
            'slug' => $post->slug,
            'is_published' => '0',
        ]))
        ->assertRedirect(route('posts.edit', $post))
        ->assertSessionHasErrors('title')
        ->assertSessionHasInput('title', '')
        ->assertSessionHasInput('is_published', '0');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Article publié',
        'is_published' => true,
    ]);
});

it('refuses the slug of another post', function () {
    Post::factory()->create(postWriteData(['slug' => 'slug-deja-pris']));
    $post = Post::factory()->create(postWriteData());

    $this->put(route('posts.update', $post), postWriteData([
        'slug' => 'slug-deja-pris',
    ]))->assertSessionHasErrors('slug');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'slug' => 'article-de-test',
    ]);
});

it('deletes a post and returns to the list', function () {
    $post = Post::factory()->create(postWriteData());

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    $this->get(route('posts.show', $post))->assertNotFound();
});

it('publishes a draft and sets its publication date', function () {
    $post = Post::factory()->create(postWriteData());

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    expect($post->fresh()->is_published)->toBeTrue();
    expect($post->fresh()->published_at)->not->toBeNull();
});

it('unpublishes a post and clears its publication date', function () {
    $post = Post::factory()->create(postWriteData([
        'is_published' => true,
        'published_at' => now(),
    ]));

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    expect($post->fresh()->is_published)->toBeFalse();
    expect($post->fresh()->published_at)->toBeNull();
});
