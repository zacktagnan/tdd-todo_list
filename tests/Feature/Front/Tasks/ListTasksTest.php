<?php

test('guests cannot see tasks', function () {
    $this
        ->get(route('tasks.index'))
        ->assertRedirect(route('login'));
})->group('list_tasks');
