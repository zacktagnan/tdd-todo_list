<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class TaskService
{
    public static function paginatedTasks(int $itemsPerPage = 5): LengthAwarePaginator
    {
        return Task::latest()->paginate($itemsPerPage);
    }

    public static function ownPaginatedTasks(User $user, int $itemsPerPage = 5): LengthAwarePaginator
    {
        return $user->tasks()->latest()->paginate($itemsPerPage);
    }

    public static function store(User $user, Request $request): void
    {
        $user->tasks()->create($request->except('completed') + [
            'completed' => $request->has('completed')
        ]);
    }

    public static function update(Task $task, Request $request): void
    {
        $task->update($request->except('completed') + [
            'completed' => $request->has('completed')
        ]);
    }

    public static function destroy(Task $task): void
    {
        $task->delete();
    }

    public static function toggle(Task $task): void
    {
        $task->update([
            'completed' => !$task->completed,
        ]);
    }
}
