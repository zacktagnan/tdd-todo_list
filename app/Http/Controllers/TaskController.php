<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\RedirectService;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $tasks = TaskService::paginatedTasks(2);
        return view('tasks.index', compact('tasks'));
        // -> Ya no es necesario obtener el TOTAL por separado
        // $totalTasks = TaskService::getTotalTasks();
        // return view('tasks.index', compact('tasks', 'totalTasks'));
    }

    public function ownList(): View
    {
        $ownTasks = TaskService::ownPaginatedTasks(auth()->user(), 2);
        return view('tasks.own-list', compact('ownTasks'));
        // -> Ya no es necesario obtener el TOTAL por separado
        // $totalTasks = TaskService::getTotalTasks(auth()->user());
        // return view('tasks.own-list', compact('ownTasks', 'totalTasks'));
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
            'routeForCancelBtn' => route('tasks.index'),
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
        return RedirectService::redirectWithSessionFlash(['tasks.index', 1], 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea CREADA satisfactoriamente.',
        ]);
    }

    public function edit(Task $task, string $referer): View
    // public function edit(Task $task): View
    {
        // if (str_contains($_SERVER['HTTP_REFERER'], 'own-list')) {
        //     $redirectRoute = 'tasks.own-list';
        // } else {
        //     $redirectRoute = 'tasks.index';
        // }
        // dd($page, $_SERVER['HTTP_REFERER'], $redirectRoute);
        $refererArr = explode('-', $referer);
        $redirectRoute = $refererArr[0] === 'index' ? 'tasks.index' : 'tasks.own-list';
        $actionRoute = $refererArr[0] === 'index'
            ? route('tasks.update', $task)
            : route('tasks.update-mine', $task);
        // $redirectRoute = $refererArr[0] === 'index' ? 'index' : 'own-list';
        $page = $refererArr[1];
        // $this->authorize('update', $task);
        Gate::authorize('update', $task);

        // return view('tasks.edit', compact('task'));
        return view('tasks.edit', [
            'task' => $task,
            'sectionLabel' => __('tasks/index.form.update_section_label'),
            'action' => $actionRoute,
            'method' => 'PUT',
            'submit' => __('tasks/index.button.update'),
            // 'routeForCancelBtn' => route('tasks.index'),
            'routeForCancelBtn' => $page > 1
                ? route($redirectRoute, ['page' => $page])
                : route($redirectRoute),
            // 'redirectRoute' => str_contains($_SERVER['HTTP_REFERER'], 'own-list')
            //     ? 'tasks.own-list'
            //     : 'tasks.index',
            // ------------------------------------------------------------------------
            // ¡¡ATENCIÓN!! El TEST no admite el uso del condicional anterior...
            // ------------------------------------------------------------------------
            'redirectRoute' => $redirectRoute,
            'redirectPage' => $page,
        ]);
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        /*
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

        // $redirectRoute = '';
        // $redirectRoute = 'tasks.index';
        // // $redirectRoute = match ($request->redirect_route) {
        // $redirectRoute = match ('index') {
        //     'index' => 'tasks.index',
        //     'own-list' => 'tasks.own-list',
        // };
        // dd($redirectRoute);
        // dd(gettype($redirectRoute));
        // $redirectRoute = $request->redirect_route;
        return RedirectService::redirectWithSessionFlash(['tasks.index', $request->redirect_page], 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        ]);

        // session()->flash('status', [
        //     'type' => 'success',
        //     'title' => '¡¡Éxito!!',
        //     'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        // ]);
        // // if ($request->redirect_page > 1) {
        // //     return redirect()->route($request->redirect_route, ['page' => $request->redirect_page]);
        // // }
        // // dd($request->redirect_route);
        // // return redirect()->route($request->redirect_route);
        // // $route = $request->redirect_route;
        // if ($request->redirect_route == 'tasks.index') {
        //     $route = 'tasks.index';
        // } else {
        //     $route = 'tasks.own-list';
        // }
        // if ($request->redirect_page > 1) {
        //     return redirect()->route($route, ['page' => $request->redirect_page]);
        // }
        // return redirect()->route($route);
        // // $route = 'tasks.index';
        // // return redirect()->route($route);
        // // return redirect()->route('tasks.index');
        */
        // ====================================================================================
        return $this->updateFinal($request, $task, ['tasks.index', $request->redirect_page]);
    }

    public function updateFromMineList(TaskRequest $request, Task $task): RedirectResponse
    {
        return $this->updateFinal($request, $task, ['tasks.own-list', $request->redirect_page]);
    }

    private function updateFinal($request, Task $task, array $routeParams): RedirectResponse
    {
        Gate::authorize('update', $task);

        TaskService::update($task, $request);

        return RedirectService::redirectWithSessionFlash($routeParams, 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ACTUALIZADA satisfactoriamente.',
        ]);
    }

    public function destroy(Task $task, Request $request): RedirectResponse
    {
        return $this->destroyFinal($task, ['tasks.index', $request->redirect_page]);
    }

    public function destroyFromMineList(Task $task, Request $request): RedirectResponse
    {
        return $this->destroyFinal($task, ['tasks.own-list', $request->redirect_page]);
    }

    private function destroyFinal(Task $task, array $routeParams): RedirectResponse
    {
        Gate::authorize('delete', $task);

        // $task->delete();
        TaskService::destroy($task);

        // $paginator = Task::paginate(2, ['id']);
        $paginator = match ($routeParams[0]) {
            'tasks.index' => TaskService::paginator(2),
            'tasks.own-list' => TaskService::paginator(2, auth()->user()),
        };
        $redirectPage = $routeParams[1] <= $paginator->lastPage()
            ? $routeParams[1]
            : $paginator->lastPage();
        // dd($paginator, $routeParams[1], $paginator->lastPage());
        $routeParamsFinal = [$routeParams[0], $redirectPage];

        return RedirectService::redirectWithSessionFlash($routeParamsFinal, 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea ELIMINADA satisfactoriamente.',
        ]);
    }

    public function toggleFromAllList(Task $task, Request $request): RedirectResponse
    {
        return $this->toggle($task, ['tasks.index', $request->redirect_page]);
    }

    public function toggleFromMineList(Task $task, Request $request): RedirectResponse
    {
        return $this->toggle($task, ['tasks.own-list', $request->redirect_page]);
    }

    private function toggle(Task $task, array $routeParams): RedirectResponse
    {
        $taskCompletedState = $task->completed ? 'PENDIENTE' : 'COMPLETADA';
        TaskService::toggle($task);

        return RedirectService::redirectWithSessionFlash($routeParams, 'status', [
            'type' => 'success',
            'title' => '¡¡Éxito!!',
            'message' => 'Tarea marcada como ' . $taskCompletedState . ' satisfactoriamente.',
        ]);
    }
}
