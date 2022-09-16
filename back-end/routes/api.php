<?php

use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::name('users.')->prefix('usuarios')->controller(UserController::class)->group(function (){
    Route::get('/', 'index')->name('index');
});
