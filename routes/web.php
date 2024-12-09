<?php

use App\Livewire\Auth\Profile\UpdateComponent as ProfileUpdateComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Common\Dashboard;
use App\Livewire\Auth\User\{
    IndexComponent as UserIndexComponent,
    CreateComponent as UserCreateComponent,
    UpdateComponent as UserUpdateComponent
};


Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/profile', ProfileUpdateComponent::class)->name('profile');

    Route::prefix('users')->group(function () {
        Route::get('/', UserIndexComponent::class)->name('users.index');
        Route::get('/create', UserCreateComponent::class)->name('users.create');
        Route::get('/update/{user}', UserUpdateComponent::class)->name('users.update');
    });
});
