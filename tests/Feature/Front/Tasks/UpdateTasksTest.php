<?php

use App\Models\Task;
use App\Models\User;

test('guests cannot render the edit tasks form', function () {
    $task = Task::factory()->create();

    $this
        // ->get(route('tasks.edit', $task))
        ->get(route('tasks.edit', [$task, 'referer' => 'index-2']))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_update');

test('users can render the edit tasks form', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        // 'title' => 'El Título de la Tarea ' . $timestamp,
        // 'description' => 'La Descripción de la Tarea ' . $timestamp,
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);

    $this
        ->actingAs($user)
        // ->get(route('tasks.edit', $task))
        ->get(route('tasks.edit', [$task, 'referer' => 'index-2']))
        ->assertOk()
        ->assertViewIs('tasks.edit')
        ->assertViewHas('task');
})->group('tasks', 'tasks_update');

test('users can update a task', function () {
    $timestamp = time();
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        // 'title' => 'El Título de la Tarea ' . $timestamp,
        // 'description' => 'La Descripción de la Tarea ' . $timestamp,
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);
    $taskUpdated = [
        // 'title' => 'Tarea actualizada ' . $timestamp,
        // 'description' => 'Descripción actualizada ' . $timestamp,
        // 'completed' => true,
        'title' => config('constants.TASK_TEST.register.updated.title'),
        'description' => config('constants.TASK_TEST.register.updated.description'),
        'completed' => config('constants.TASK_TEST.register.updated.completed'),
    ];

    $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), [
            'title' => $taskUpdated['title'],
            'description' => $taskUpdated['description'],
            'completed' => $taskUpdated['completed'],
        ])
        ->assertSessionHas(config('constants.SESSION_NAME'), [
            'type' => config('constants.SESSION_TYPE'),
            'title' => __('tasks/notifications.success.title'),
            'message' => __('tasks/notifications.general_message', [
                'state' => __('tasks/notifications.updated')
            ]),
        ])
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
        // 'title' => 'El Título de la Tarea ' . $timestamp,
        // 'description' => 'La Descripción de la Tarea ' . $timestamp,
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);
    $taskUpdated = [
        // 'title' => 'Tarea actualizada ' . $timestamp,
        // 'description' => 'Descripción actualizada ' . $timestamp,
        // 'completed' => true,
        'title' => config('constants.TASK_TEST.register.updated.title'),
        'description' => config('constants.TASK_TEST.register.updated.description'),
        'completed' => config('constants.TASK_TEST.register.updated.completed'),
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

test('users cannot update a task from another user - only admins', function () {
    $user = User::factory()->create();
    $taskStored = [
        // 'title' => 'Tarea posible de actualizar',
        // 'description' => 'La Descripción de la Tarea a actualizar',
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
    ];
    $task = $user->tasks()->create([
        'title' => $taskStored['title'],
        'description' => $taskStored['description'],
    ]);
    $taskUpdated = [
        // 'title' => 'Tarea actualizada por otro',
        // 'description' => 'Descripción actualizada por otro',
        // 'completed' => true,
        'title' => config('constants.TASK_TEST.register.updated.title'),
        'description' => config('constants.TASK_TEST.register.updated.description'),
        'completed' => config('constants.TASK_TEST.register.updated.completed'),
    ];
    $anotherUser = User::factory()->create();

    $this
        ->actingAs($anotherUser)
        ->put(route('tasks.update', $task), [
            'title' => $taskUpdated['title'],
            'description' => $taskUpdated['description'],
            'completed' => $taskUpdated['completed'],
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'user_id' => $user->id,
        'title' => $taskStored['title'],
        'description' => $taskStored['description'],
        'completed' => false,
    ]);
})->group('tasks', 'tasks_update');
