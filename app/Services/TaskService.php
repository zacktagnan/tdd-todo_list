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

    public static function paginator(int $itemsPerPage = 5, User|null $user = null): LengthAwarePaginator
    {
        if (is_null($user)) {
            return Task::paginate($itemsPerPage, ['id']);
        }
        return $user->tasks()->paginate($itemsPerPage, ['id']);
    }

    public static function store(User $user, Request $request): void
    {
        $user->tasks()->create($request->except('completed') + [
            'completed' => $request->has('completed')
        ]);
    }

    public static function update(Task $task, Request $request): void
    {
        $task->update($request->except(['completed', 'redirect_route', 'redirect_page']) + [
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

    /**
     * Ya no es necesario pues, al paginar, se puede obtener el TOTAL del listado
     * a través del método "total()" del conjunto de registros paginados, por ejemplo:
     *      $tasks->total()
     */
    // public static function getTotalTasks(User|null $user = null): int
    // {
    //     if (is_null($user)) {
    //         return Task::count();
    //     }

    //     return $user->tasks()->count();
    // }
}
