<?php

use App\Models\Task;

test('guests cannot delete tasks', function () {
    $task = Task::factory()->create();

    $this
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_delete');
