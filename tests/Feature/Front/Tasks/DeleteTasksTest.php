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
        // 'title' => 'El Título de la Tarea a eliminar ' . $timestamp,
        // 'description' => 'La Descripción de la Tarea a eliminar ' . $timestamp,
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);

    $this
        ->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertSessionHas(
            config('constants.SESSION_NAME'),
            [
                'type' => config('constants.SESSION_TYPE'),
                'title' => __('tasks/notifications.success.title'),
                'message' => __('tasks/notifications.general_message', [
                    'state' => __('tasks/notifications.deleted')
                ]),
            ]
        )
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
})->group('tasks', 'tasks_delete');

test('users can delete tasks from own list', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        // 'title' => 'El Título de la Tarea propia a eliminar ' . $timestamp,
        // 'description' => 'La Descripción de la Tarea propia a eliminar ' . $timestamp,
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);

    $this
        ->actingAs($user)
        ->delete(route('tasks.destroy-mine', $task))
        ->assertSessionHas(
            config('constants.SESSION_NAME'),
            [
                'type' => config('constants.SESSION_TYPE'),
                'title' => __('tasks/notifications.success.title'),
                'message' => __('tasks/notifications.general_message', [
                    'state' => __('tasks/notifications.deleted')
                ]),
            ]
        )
        ->assertRedirect(route('tasks.own-list'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
})->group('tasks', 'tasks_delete');

test('users cannot delete a task from another user - only admins', function () {
    $user = User::factory()->create();
    $taskStored = [
        // 'title' => 'Tarea posible de eliminar',
        // 'description' => 'La Descripción de la Tarea a eliminar',
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
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
