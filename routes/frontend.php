<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageController::class)->name('homepage');
Route::get('{page:slug}', PageController::class)->name('page');
