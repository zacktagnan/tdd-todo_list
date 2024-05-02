<?php

use App\Models\User;

test('guests cannot see tasks', function () {
    $this
        ->get(route('tasks.index'))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_list');

test('users can render the task list', function () {
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
})->group('tasks', 'tasks_list');

test('users can render their own tasks list', function () {
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('tasks.own-list'))
        ->assertSuccessful();

    $response->assertViewIs('tasks.own-list')
        ->assertViewHas('ownTasks');
})->group('tasks', 'tasks_list');

test('users can toggle tasks from index list', function () {
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        // 'title' => 'Tarea a Togglear',
        // 'description' => 'La Descripción de la Tarea a Togglear',
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('tasks.toggle', $task));

    if ($task->completed) {
        $response->assertSessionHas(config('constants.SESSION_NAME'), [
            'type' => config('constants.SESSION_TYPE'),
            'title' => __('tasks/notifications.success.title'),
            'message' => __('tasks/notifications.toggle_message', [
                'state' => __('tasks/notifications.pending')
            ]),
        ]);
    } else {
        $response->assertSessionHas(config('constants.SESSION_NAME'), [
            'type' => config('constants.SESSION_TYPE'),
            'title' => __('tasks/notifications.success.title'),
            'message' => __('tasks/notifications.toggle_message', [
                'state' => __('tasks/notifications.completed')
            ]),
        ]);
    }

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'user_id' => $user->id,
        'title' => $task->title,
        'description' => $task->description,
        'completed' => !$task->completed,
    ]);
})->group('tasks', 'tasks_list');

test('users can toggle tasks from own list', function () {
    $user = User::factory()->create();
    $task = $user->tasks()->create([
        // 'title' => 'Tarea propia a Togglear',
        // 'description' => 'La Descripción de la Tarea propia a Togglear',
        // 'completed' => false,
        'title' => config('constants.TASK_TEST.register.stored.title'),
        'description' => config('constants.TASK_TEST.register.stored.description'),
        'completed' => config('constants.TASK_TEST.register.stored.completed'),
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('tasks.toggle-mine', $task));

    if ($task->completed) {
        $response->assertSessionHas(config('constants.SESSION_NAME'), [
            'type' => config('constants.SESSION_TYPE'),
            'title' => __('tasks/notifications.success.title'),
            'message' => __('tasks/notifications.toggle_message', [
                'state' => __('tasks/notifications.pending')
            ]),
        ]);
    } else {
        $response->assertSessionHas(config('constants.SESSION_NAME'), [
            'type' => config('constants.SESSION_TYPE'),
            'title' => __('tasks/notifications.success.title'),
            'message' => __('tasks/notifications.toggle_message', [
                'state' => __('tasks/notifications.completed')
            ]),
        ]);
    }

    $response->assertRedirect(route('tasks.own-list'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'user_id' => $user->id,
        'title' => $task->title,
        'description' => $task->description,
        'completed' => !$task->completed,
    ]);
})->group('tasks', 'tasks_list');
