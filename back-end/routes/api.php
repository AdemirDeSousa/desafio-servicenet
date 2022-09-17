<?php

use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::name('users.')->prefix('usuarios')->controller(UserController::class)->group(function (){
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});
