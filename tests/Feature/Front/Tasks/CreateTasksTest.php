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

    // $response->assertViewIs('tasks.create')
    //     ->assertSee('Nueva')
    //     ->assertSee('Nombre')
    //     ->assertSee('Completada')
    //     ->assertSee('Crear');
    $response->assertViewIs('tasks.create');
})->group('tasks', 'tasks_create');

test('users can create tasks', function () {
    $timestamp = time();

    $this
        ->actingAs(User::factory()->create())
        ->post(route('tasks.store'), [
            'title' => 'Tarea ' . $timestamp,
            'description' => 'Descripción ' . $timestamp,
        ])
        ->assertSessionHas('status', 'Tarea creada satisfactoriamente.')
        ->assertRedirect(route('tasks.index'));

    $this
        ->assertDatabaseHas('tasks', [
            'user_id' => auth()->id(),
            'title' => 'Tarea ' . $timestamp,
            'description' => 'Descripción ' . $timestamp,
            'completed' => false,
        ]);
})->group('tasks', 'tasks_create');

test('validation works on create task', function () {
    $this
        ->actingAs(User::factory()->create())
        ->post(route('tasks.store'), [
            'title' => '',
            'description' => '',
        ])
        ->assertSessionHasErrors(['title', 'description']);
})->group('tasks', 'tasks_create');
