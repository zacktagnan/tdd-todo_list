<?php

use App\Models\Task;
use App\Models\User;

test('guests cannot render the edit tasks form', function () {
    $task = Task::factory()->create();

    $this
        ->get(route('tasks.edit', $task))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_update');

test('users can render the edit tasks form', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        'title' => 'El Título de la Tarea ' . $timestamp,
        'description' => 'La Descripción de la Tarea ' . $timestamp,
        'completed' => false,
    ]);

    $this
        ->actingAs($user)
        ->get(route('tasks.edit', $task))
        ->assertOk()
        ->assertViewIs('tasks.edit')
        ->assertViewHas('task');
})->group('tasks', 'tasks_update');

test('users can update a task', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        'title' => 'El Título de la Tarea ' . $timestamp,
        'description' => 'La Descripción de la Tarea ' . $timestamp,
        'completed' => false,
    ]);
    $taskUpdated = [
        'title' => 'Tarea actualizada ' . $timestamp,
        'description' => 'Descripción actualizada ' . $timestamp,
        'completed' => true,
    ];

    $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), [
            'title' => $taskUpdated['title'],
            'description' => $taskUpdated['description'],
            'completed' => $taskUpdated['completed'],
        ])
        ->assertSessionHas('status', 'Tarea actualizada satisfactoriamente.')
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => $taskUpdated['title'],
        'description' => $taskUpdated['description'],
        'completed' => $taskUpdated['completed'],
    ]);
})->group('tasks', 'tasks_update');

test('validation works on update task', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        'title' => 'El Título de la Tarea ' . $timestamp,
        'description' => 'La Descripción de la Tarea ' . $timestamp,
        'completed' => false,
    ]);
    $taskUpdated = [
        'title' => 'Tarea actualizada ' . $timestamp,
        'description' => 'Descripción actualizada ' . $timestamp,
        'completed' => true,
    ];

    $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), [
            'title' => '',
            'description' => '',
            'completed' => $taskUpdated['completed'],
        ])
        ->assertSessionHasErrors(['title', 'description']);
})->group('tasks', 'tasks_update');
