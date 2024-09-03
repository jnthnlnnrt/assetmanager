<?php

use App\Livewire\Dashboard;
use App\Livewire\Organization\Departments;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', Dashboard::class)->middleware('auth')->name('dashboard');

Route::get('/organization/departments', Departments::class)->middleware('auth')->name('departments');