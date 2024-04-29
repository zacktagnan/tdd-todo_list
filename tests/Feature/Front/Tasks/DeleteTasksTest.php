<?php

use App\Models\Task;
use App\Models\User;

test('guests cannot delete tasks', function () {
    $task = Task::factory()->create();

    $this
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_delete');

test('users can delete tasks', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        'title' => 'El Título de la Tarea a eliminar ' . $timestamp,
        'description' => 'La Descripción de la Tarea a eliminar ' . $timestamp,
        'completed' => false,
    ]);

    $this
        ->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertSessionHas('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ELIMINADA satisfactoriamente.',
        ])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
})->group('tasks', 'tasks_delete');

test('users cannot delete a task from another user - only admins', function () {
    $user = User::factory()->create();
    $taskStored = [
        'title' => 'Tarea posible de eliminar',
        'description' => 'La Descripción de la Tarea a eliminar',
    ];
    $task = $user->tasks()->create([
        'title' => $taskStored['title'],
        'description' => $taskStored['description'],
    ]);
    $anotherUser = User::factory()->create();

    $this
        ->actingAs($anotherUser)
        ->delete(route('tasks.destroy', $task))
        ->assertForbidden();

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'user_id' => $user->id,
        'title' => $taskStored['title'],
        'description' => $taskStored['description'],
        'completed' => false,
    ]);
})->group('tasks', 'tasks_delete');
