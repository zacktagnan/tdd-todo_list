<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        /** @var \App\Models\User $authUser **/
        $authUser = auth()->user();
        $tasks = $authUser->tasks()->latest()->paginate(3);
        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'title' => 'required|unique:tasks|max:255',
            'description' => 'required',
        ]);
        /** @var \App\Models\User $authUser **/
        $authUser = auth()->user();
        $authUser->tasks()->create([
            'title' => data_get($data, 'title'),
            'description' => data_get($data, 'description'),
            'completed' => request()->has('completed'),
        ]);

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
        return view('tasks.edit', compact('task'));
    }

    public function update(Task $task): RedirectResponse
    {
        request()->validate([
            'title' => 'required|unique:tasks,title,' . $task->id . '|max:255',
            'description' => 'required',
        ]);

        $task->update([
            'title' => request('title'),
            'description' => request('description'),
            'completed' => request()->has('completed'),
        ]);

        session()->flash('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        ]);
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        session()->flash('status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ELIMINADA satisfactoriamente.',
        ]);
        return redirect()->route('tasks.index');
    }
}
