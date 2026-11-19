<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

function authorizationPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article de l’auteur',
        'slug' => 'article-de-lauteur',
        'body' => 'Contenu suffisamment long pour passer la validation.',
    ], $overrides);
}

it('redirects guests from writing routes while keeping public article pages available', function () {
    $post = Post::factory()->published()->create();

    $this->get(route('posts.create'))->assertRedirect(route('login'));
    $this->get(route('admin.categories.index'))->assertRedirect(route('login'));
    $this->get(route('posts.index'))->assertOk();
    $this->get(route('posts.show', $post))->assertOk();
});

it('assigns a new post to the authenticated author regardless of submitted ownership', function () {
    $author = User::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($author)
        ->post(route('posts.store'), authorizationPostData(['user_id' => $otherUser->id]))
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'slug' => 'article-de-lauteur',
        'user_id' => $author->id,
    ]);
});

it('allows authors to edit their own posts but denies other authors', function () {
    $owner = User::factory()->create();
    $otherAuthor = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($otherAuthor)
        ->get(route('posts.edit', $post))
        ->assertForbidden();

    $this->put(route('posts.update', $post), authorizationPostData([
        'slug' => $post->slug,
    ]))->assertForbidden();

    $this->delete(route('posts.destroy', $post))->assertForbidden();
    $this->patch(route('posts.publication', $post))->assertForbidden();

    $this->actingAs($owner)
        ->get(route('posts.edit', $post))
        ->assertOk();

    $this->put(route('posts.update', $post), authorizationPostData([
        'title' => 'Article modifié par son auteur',
        'slug' => $post->slug,
    ]))->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Article modifié par son auteur',
    ]);
});

it('allows admins to manage posts owned by other users', function () {
    $owner = User::factory()->create();
    $admin = User::factory()->admin()->create();
    $post = Post::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($admin)
        ->get(route('posts.edit', $post))
        ->assertOk();

    $this->actingAs($admin)
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('limits category administration to admins', function () {
    $author = User::factory()->create();
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    $this->actingAs($author)
        ->get(route('admin.categories.index'))
        ->assertForbidden()
        ->assertSee('Accès interdit')
        ->assertSee('Erreur 403');

    $this->actingAs($author)
        ->get(route('admin.categories.edit', $category))
        ->assertForbidden();

    $this->actingAs($author)
        ->post(route('admin.categories.store'), [
            'name' => 'Interdit',
            'slug' => 'interdit',
        ])
        ->assertForbidden();

    $this->actingAs($author)
        ->put(route('admin.categories.update', $category), [
            'name' => 'Interdit',
            'slug' => 'interdit',
        ])
        ->assertForbidden();

    $this->actingAs($admin)
        ->get(route('admin.categories.index'))
        ->assertOk();

    $this->actingAs($author)
        ->get(route('home'))
        ->assertDontSee(route('admin.categories.index'), false);

    $this->actingAs($admin)
        ->get(route('home'))
        ->assertSee(route('admin.categories.index'), false);
});

it('shows post management controls only to an owner or admin', function () {
    $owner = User::factory()->create();
    $visitor = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $owner->id]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertDontSee('Modifier l&#039;article', false)
        ->assertDontSee('Confirmer la suppression');

    $this->actingAs($visitor)
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertDontSee('Modifier l&#039;article', false)
        ->assertDontSee('Confirmer la suppression');

    $this->actingAs($owner)
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee("Modifier l'article", false)
        ->assertSee('Confirmer la suppression');
});

it('lists only the authenticated author’s posts on the my posts page', function () {
    $author = User::factory()->create();
    foreach (range(1, 5) as $number) {
        Post::factory()->create([
            'user_id' => $author->id,
            'title' => "Article personnel {$number}",
            'slug' => "article-personnel-{$number}",
        ]);
    }
    Post::factory()->create([
        'title' => 'Article d’un autre',
        'slug' => 'article-autre',
    ]);

    $this->actingAs($author)
        ->get(route('posts.mine'))
        ->assertOk()
        ->assertSee('Article personnel 5')
        ->assertDontSee('Article personnel 1')
        ->assertDontSee('Article d’un autre')
        ->assertSee(route('posts.mine', ['page' => 2]), false);

    $this->get(route('posts.mine', ['page' => 2]))
        ->assertOk()
        ->assertSee('Article personnel 1')
        ->assertDontSee('Article d’un autre');
});
