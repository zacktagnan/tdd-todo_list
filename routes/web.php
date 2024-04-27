<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // ================================
    // :: Prueba de Debug - ini ::
    $a = 7;
    $b = 4;
    $c = $a + $b;
    $d = $a * $b;
    $aloha = 'Aloha!!';
    // echo $aloha;
    // :: Prueba de Debug - fin ::
    // ================================
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// -----------------------------------------------------------------------------------------------


Route::resource('tasks', TaskController::class)->middleware('auth')->except(['show']);

// Route::middleware(['auth'])->group(function () {
//     Route::prefix('tasks')->as('tasks.')->group(function () {
//         Route::put('/{task}/toggle', [TaskController::class, 'toggle'])->name('toggle');
//     });
// });

//o

Route::put('/{task}/toggle', [TaskController::class, 'toggle'])
    ->prefix('tasks')
    ->name('tasks.toggle')
    ->middleware('auth');
