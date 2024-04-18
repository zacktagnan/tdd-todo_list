<?php

test('guests cannot create tasks', function () {
    $this
        ->get(route('tasks.create'))
        ->assertRedirect(route('login'));
})->group('tasks', 'tasks_create');
