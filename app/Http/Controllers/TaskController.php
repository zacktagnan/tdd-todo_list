<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
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
        $tasks = TaskService::paginatedTasks(auth()->user(), 3);
        return view('tasks.index', compact('tasks'));
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
        session()->flash('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea CREADA satisfactoriamente.',
        ]);
        return redirect()->route('tasks.index');
    }

    public function edit(Task $task): View
    {
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

        session()->flash('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        ]);
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        // $task->delete();
        TaskService::destroy($task);

        session()->flash('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ELIMINADA satisfactoriamente.',
        ]);
        return redirect()->route('tasks.index');
    }
}
