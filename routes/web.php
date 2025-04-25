<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TaskCategoryController;

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

Route::get('/', [LoginController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
});

Route::match(['GET', 'POST'], '/signup', [SignupController::class, 'index'])->name('signup');
Route::match(['GET', 'POST'], '/login', [LoginController::class, 'index'])->name('login');
Route::match(['GET', 'POST'], '/forgot/password', [LoginController::class, 'forget_password'])->name('forgot-password');
Route::match(['GET', 'POST'], '/reset/password', [LoginController::class, 'reset_password'])->name('reset-password');
Route::get('/admincp/tasks', [TaskController::class, 'index'])->name('tasks');

// Dashboard route is protected by the auth middleware
Route::get('/admincp', [TaskController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin-dashboard');
Route::match(['GET', 'POST'], '/admincp/task/create', [TaskController::class, 'create'])->name('create-task');
Route::match(['GET', 'POST'], '/admincp/task/update/{task}', [TaskController::class, 'update'])->name('edit-task');
Route::delete('/admincp/task/delete/{task}', [TaskController::class, 'delete'])->name('delete-task');
Route::get('/admincp/task/categories', [TaskCategoryController::class, 'index'])->name('task-categories');
Route::match(['GET', 'POST'], '/admincp/task/category/create', [TaskCategoryController::class, 'create'])->name('create-task-category');
Route::match(['GET', 'POST'], '/admincp/task/category/update/{category}', [TaskCategoryController::class, 'update'])->name('edit-task-category');
Route::delete('/admincp/task/category/delete/{task}', [TaskCategoryController::class, 'delete'])->name('delete-task-category');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');