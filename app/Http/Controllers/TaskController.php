<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\RedirectService;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        // Todas las Task de cualquier usuario
        // $tasks = Task::all();
        // ------------------------------------------------
        // Solo las Task del usuario autenticado
        // $tasks = auth()->user()->tasks()->paginate(5);
        // - - - - - - - - - - - - - - - - - - - - - - - -
        /** @var \App\Models\User $authUser **/
        // $authUser = auth()->user();
        // $tasks = $authUser->tasks()->latest()->paginate(3);
        $tasks = TaskService::paginatedTasks(3);
        $totalTasks = TaskService::getTotalTasks();
        return view('tasks.index', compact('tasks', 'totalTasks'));
    }

    public function ownList(): View
    {
        $ownTasks = TaskService::ownPaginatedTasks(auth()->user(), 3);
        $totalTasks = TaskService::getTotalTasks(auth()->user());
        return view('tasks.own-list', compact('ownTasks', 'totalTasks'));
    }

    public function create(): View
    {
        // return view('tasks.create');
        return view('tasks.create', [
            'task' => new Task(),
            'sectionLabel' => __('tasks/index.form.create_section_label'),
            'action' => route('tasks.store'),
            'method' => 'POST',
            'submit' => __('tasks/index.button.store'),
        ]);
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        // $data = request()->validate([
        //     'title' => 'required|unique:tasks|max:255',
        //     'description' => 'required',
        // ]);
        // /** @var \App\Models\User $authUser **/
        // $authUser = auth()->user();
        // $authUser->tasks()->create([
        //     'title' => data_get($data, 'title'),
        //     'description' => data_get($data, 'description'),
        //     'completed' => request()->has('completed'),
        // ]);
        // --------------------------------------------------------
        /** @var \App\Models\User $authUser **/
        $authUser = auth()->user();
        // Solo vale si NO hay un CHECKBOX que haya enviado como activo (ON)
        // $authUser->tasks()->create($request->all());
        // o
        // (las dos siguientes formas si funcionan)
        // $authUser->tasks()->create($request->except('completed') + [
        //     'completed' => $request->has('completed')
        // ]);
        // o
        // $authUser->tasks()->create([
        //     'title' => $request->validated('title'),
        //     'description' => $request->validated('description'),
        //     'completed' => $request->has('completed'),
        // ]);
        // o
        // (mediante el Service relacionado)
        TaskService::store(auth()->user(), $request);

        // session()->flash('status', 'Tarea CREADA satisfactoriamente.');
        // ----------------------------------------------------------------
        // session()->flash('status', [
        //     'type' => 'success',
        //     'title' => '¡¡Éxito!!',
        //     'message' => 'Tarea CREADA satisfactoriamente.',
        // ]);
        // return redirect()->route('tasks.index');
        // ----------------------------------------------------------------
        return RedirectService::redirectWithSessionFlash('tasks.index', 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea CREADA satisfactoriamente.',
        ]);
    }

    public function edit(Task $task): View
    {
        // $this->authorize('update', $task);
        Gate::authorize('update', $task);

        // return view('tasks.edit', compact('task'));
        return view('tasks.edit', [
            'task' => $task,
            'sectionLabel' => __('tasks/index.form.update_section_label'),
            'action' => route('tasks.update', $task),
            'method' => 'PUT',
            'submit' => __('tasks/index.button.update'),
        ]);
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        // $this->authorize('update', $task);
        Gate::authorize('update', $task);

        // Solo vale si NO hay un CHECKBOX que haya enviado como activo (ON)
        // $task->update($request->all());
        // o
        // (las dos siguientes formas si funcionan)
        // $task->update($request->except('completed') + [
        //     'completed' => $request->has('completed')
        // ]);
        // o
        // $task->update([
        //     'title' => $request->validated('title'),
        //     'description' => $request->validated('description'),
        //     'completed' => $request->has('completed'),
        // ]);
        // o
        // (mediante el Service relacionado)
        TaskService::update($task, $request);

        return RedirectService::redirectWithSessionFlash('tasks.index', 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        // $task->delete();
        TaskService::destroy($task);

        return RedirectService::redirectWithSessionFlash('tasks.index', 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ELIMINADA satisfactoriamente.',
        ]);
    }

    public function toggleFromAllList(Task $task): RedirectResponse
    {
        return $this->toggle($task, 'tasks.index');
    }

    public function toggleFromMineList(Task $task): RedirectResponse
    {
        return $this->toggle($task, 'tasks.own-list');
    }

    public function toggle(Task $task, string $route): RedirectResponse
    {
        $taskCompletedState = $task->completed ? 'PENDIENTE' : 'COMPLETADA';
        TaskService::toggle($task);

        return RedirectService::redirectWithSessionFlash($route, 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea marcada como ' . $taskCompletedState . ' satisfactoriamente.',
        ]);
    }
}
