<?php

use App\Livewire\Dashboard;
use App\Livewire\Organization\Departments;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::get('/organization/departments', Departments::class)->name('departments');

