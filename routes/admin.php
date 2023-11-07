<?php

use App\Http\Controllers\Admin\Cms\PageEditorController;
use App\Http\Livewire\Admin\Cms\Menu\MenuBuilderController;
use App\Http\Livewire\Admin\Cms\Menu\MenuIndexController;
use App\Http\Livewire\Admin\Cms\Page\PageCreateController;
use App\Http\Livewire\Admin\Cms\Page\PageIndexController;
use App\Http\Livewire\Admin\Cms\Page\PageShowController;
use App\Http\Livewire\Admin\Dashboard\DashboardController;
use App\Http\Livewire\Admin\Profile\StaffProfileController;
use App\Http\Livewire\Admin\System\Settings\SettingsController;
use App\Http\Livewire\Admin\System\Staff\StaffCreateController;
use App\Http\Livewire\Admin\System\Staff\StaffIndexController;
use App\Http\Livewire\Admin\System\Staff\StaffShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('cms')->as('cms.')->group(function () {
        Route::middleware('auth:admin')->group(function () {
            Route::get('menus', MenuIndexController::class)->name('menu.index');
            Route::get('menus/{menu}/builder', MenuBuilderController::class)->name('menu.builder');
        });

        Route::middleware('auth:admin')->group(function () {
            Route::get('pages', PageIndexController::class)->name('pages.index');
            Route::get('pages/create', PageCreateController::class)->name('pages.create');
            Route::get('pages/{page}', PageShowController::class)->name('pages.show');
            Route::get('pages/{page}/editor', [PageEditorController::class, 'editor'])->name('pages.editor');
        });

    });

    Route::prefix('system')->middleware('auth:admin')->as('system.')->group(function () {
        Route::middleware('auth:admin')->group(function () {
            Route::get('staff', StaffIndexController::class)->name('staff.index');
            Route::get('staff/create', StaffCreateController::class)->name('staff.create');
            Route::get('staff/{staff}', StaffShowController::class)->name('staff.show');
        });

        Route::middleware('auth:admin')->group(function () {
            Route::get('settings', SettingsController::class)->name('settings');
        });
    });

    Route::get('staff/account', StaffProfileController::class)->name('staff.profile');
});
