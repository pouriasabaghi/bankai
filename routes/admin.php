<?php

use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\CustomerController;
use Illuminate\Support\Facades\Route;


Route::group([],function(){
    Route::get('/dashboard', fn()=> view('admin.dashboard.index'))->name('dashboard');

   Route::resource('customers', CustomerController::class)->except('show');

   Route::resource('companies', CompanyController::class)->except('show');
});

