<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;

Route::view('/', 'welcome');

// --------------------- STUDENT --------------------- //
// Register
Route::get('/student/register', fn () => view('students.register'))->name('students.register');
Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');

// Login
Route::get('/student/login', fn () => view('students.login'))->name('students.login');
Route::post('/student/login', [StudentController::class, 'login']);

// Dashboard
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');

// Logout
Route::get('/student/logout', [StudentController::class, 'logout'])->name('students.logout');

// --------------------- TEACHER --------------------- //
// Register
Route::get('/teacher/register', fn()=>view('teacher.register'))->name('teacher.register');
Route::post('/teacher/register', [TeacherController::class,'register']);

// Login
Route::get('/teacher/login', fn()=>view('teacher.login'))->name('teacher.login');
Route::post('/teacher/login',[TeacherController::class,'login']);

// Dashboard
Route::get('/teacher/dashboard',[TeacherController::class,'dashboard'])->name('teacher.dashboard');

// Student CRUD by teacher
Route::post('/teacher/student',[TeacherController::class,'storeStudent'])->name('teacher.student.store');
Route::put('/teacher/student/{id}',[TeacherController::class,'updateStudent'])->name('teacher.student.update');
Route::delete('/teacher/student/{id}',[TeacherController::class,'deleteStudent'])->name('teacher.student.delete');

// Logout
Route::get('/teacher/logout',[TeacherController::class,'logout'])->name('teacher.logout');


/* ---------- PRINCIPAL ---------- */

Route::get('/principal/register', fn () => view('principal.register'));
Route::post('/principal/register', [PrincipalController::class, 'register'])->name('principal.register');

Route::get('/principal/login', fn () => view('principal.login'))->name('principal.login');
Route::post('/principal/login', [PrincipalController::class, 'login']);

Route::get('/principal/dashboard', [PrincipalController::class, 'dashboard'])
    ->name('principal.dashboard');

Route::post('/principal/logout', [PrincipalController::class, 'logout'])
    ->name('principal.logout');

/* STUDENT CONTROL */
Route::post('/principal/student/update/{id}', [PrincipalController::class, 'updateStudent']);
Route::get('/principal/student/delete/{id}', [PrincipalController::class, 'deleteStudent']);

/* TEACHER CONTROL */
Route::post('/principal/teacher/update/{id}', [PrincipalController::class, 'updateTeacher']);
Route::get('/principal/teacher/delete/{id}', [PrincipalController::class, 'deleteTeacher']);
Route::get('/principal/register', fn () => view('principal.register'));
Route::post('/principal/register', [PrincipalController::class, 'register'])->name('principal.register');

Route::get('/principal/login', fn () => view('principal.login'))->name('principal.login');
Route::post('/principal/login', [PrincipalController::class, 'login']);
