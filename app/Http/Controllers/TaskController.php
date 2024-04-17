<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
}
