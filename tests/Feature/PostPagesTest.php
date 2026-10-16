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
