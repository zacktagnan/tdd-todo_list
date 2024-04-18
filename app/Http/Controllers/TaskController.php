<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $tasks = $authUser->tasks()->paginate(5);
        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store() //: RedirectResponse
    {
        /** @var \App\Models\User $authUser **/
        $authUser = auth()->user();
        $authUser->tasks()->create([
            'title' => request('title'),
            'description' => request('description'),
            'completed' => request()->has('completed'),
        ]);

        session()->flash('status', 'Tarea creada satisfactoriamente.');
        return redirect()->route('tasks.index');
    }
}
