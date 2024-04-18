<?php

use App\Models\User;

test('guests cannot create tasks', function () {
    $this
        ->get(route('tasks.create'))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_create');

test('users can render the create tasks form', function () {
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('tasks.create'))
        // ->assertSuccessful()
        // igual que
        ->assertOk();

    $response->assertViewIs('tasks.create')
        ->assertSee('Crear Tarea')
        ->assertSee('Nombre')
        ->assertSee('Completada')
        ->assertSee('Crear');
})->group('tasks', 'tasks_create');
