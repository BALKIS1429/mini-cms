<?php

use App\Models\User;

it('allows an admin to promote an author', function () {
    $admin = User::factory()->admin()->create();
    $author = User::factory()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $author), ['role' => 'admin'])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'Rôle mis à jour.');

    $this->assertDatabaseHas('users', [
        'id' => $author->id,
        'role' => 'admin',
    ]);
});

it('forbids an admin from changing their own role', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $admin), ['role' => 'author'])
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'role' => 'admin',
    ]);
});
