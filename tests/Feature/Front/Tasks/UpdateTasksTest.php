<?php

use App\Models\Task;

test('guests cannot render the edit tasks form', function () {
    $task = Task::factory()->create();

    $this
        ->get(route('tasks.edit', $task))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_update');
