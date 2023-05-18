<?php

use App\Http\Controllers\admin\CustomerController;
use Illuminate\Support\Facades\Route;


Route::group([],function(){
    Route::get('/dashboard', fn()=> view('admin.dashboard.index'))->name('dashboard');

   Route::resource('customers', CustomerController::class);
});

