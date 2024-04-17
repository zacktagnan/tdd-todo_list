<?php

use App\Models\User;

test('guests cannot see tasks', function () {
    $this
        ->get(route('tasks.index'))
        ->assertRedirect(route('login'));
})->group('list_tasks');

test('users can render the tasks list', function () {
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('tasks.index'))
        ->assertSuccessful();

    $response->assertViewIs('tasks.index')
        ->assertViewHas('tasks');
    // ->assertViewHas('tasks')
    // -> Solo vale texto que se imprima directamente en el HTML
    // -> No vale texto dentro de atributos o de métodos extra, ni claves
    // ->assertSeeText('Mis Tareas');
    // ->assertSeeText('tasks/index.section_label');
})->group('list_tasks');
