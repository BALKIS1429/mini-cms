<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

it('registers a new author and signs them in', function () {
    $this->post(route('register'), [
        'name' => 'Amina Test',
        'email' => 'amina@example.test',
        'password' => 'motdepasse123',
        'password_confirmation' => 'motdepasse123',
        'role' => 'admin',
    ])
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Votre compte a été créé.');

    $user = User::where('email', 'amina@example.test')->firstOrFail();

    $this->assertAuthenticatedAs($user);
    expect($user->role)->toBe('author');
    expect(Hash::check('motdepasse123', $user->password))->toBeTrue();
});

it('validates registration email uniqueness and password confirmation', function () {
    User::factory()->create(['email' => 'existant@example.test']);

    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Amina Test',
            'email' => 'existant@example.test',
            'password' => 'motdepasse123',
            'password_confirmation' => 'different',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors(['email', 'password']);

    $this->assertDatabaseCount('users', 1);
});

it('authenticates with valid credentials and honors the remember checkbox', function () {
    $user = User::factory()->create([
        'email' => 'auteur@example.test',
        'password' => 'motdepasse123',
    ]);

    $response = $this->post(route('login'), [
        'email' => 'auteur@example.test',
        'password' => 'motdepasse123',
        'remember' => '1',
    ]);

    $response->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Connexion réussie.')
        ->assertCookie(Auth::guard()->getRecallerName());

    $this->assertAuthenticatedAs($user);
});

it('shows a neutral credential error and only preserves the email on failed login', function () {
    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'inconnu@example.test',
            'password' => 'mauvais-mot-de-passe',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email')
        ->assertSessionHasInput('email', 'inconnu@example.test')
        ->assertSessionMissing('_old_input.password');

    $this->assertGuest();
});

it('logs out and invalidates the authenticated session', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('logout'))
        ->assertRedirect(route('home'))
        ->assertSessionHas('success', 'Vous êtes déconnecté.');

    $this->assertGuest();
});
