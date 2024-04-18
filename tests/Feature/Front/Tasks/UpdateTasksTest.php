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
