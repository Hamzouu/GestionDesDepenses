<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified', 'check_approval'])->name('home');

Route::get('/contact', function () {
    return view('contact');
})->middleware(['auth', 'verified','check_approval'])->name('contact');

Route::get('/waiting-approval', function () {
    return view('waiting-approval');
})->name('waiting-approval')->middleware('check_approval');


Route::middleware('auth','check_approval' )->group(function () {


    
    Route::get('/admin', [AdminController::class, 'listUsers'])->name('admin.userList');
    Route::post('/admin/approve/{user}', [AdminController::class, 'approveUser'])->name('admin.approveUser');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/category/{category}', [ActivityController::class, 'filterByCategory'])->name('activities.filterByCategory');

    // Afficher la page de modification de l'activité
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');

    // Mettre à jour l'activité
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');

    // Supprimer l'activité
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    
    Route::get('/activities/{activity}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/activities/{activity}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/activities/{activity}/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');


    Route::get('/expenses/{activity}/edit/{expense}', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::delete('/activities/{activity}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');




}); 



require __DIR__.'/auth.php';
