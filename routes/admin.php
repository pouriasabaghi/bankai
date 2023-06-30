<?php

use App\Http\Controllers\admin\CardController;
use App\Http\Controllers\Admin\CheckController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\ContractController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\InstallmentController;
use App\Http\Controllers\admin\ReceiveController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\TypeController;

use Illuminate\Support\Facades\Route;


Route::group([], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('companies', CompanyController::class)->except('show');
    Route::resource('types', TypeController::class)->except('show');
    Route::resource('services', ServiceController::class)->except('show');
    Route::resource('cards', CardController::class)->except('show');
    Route::resource('contracts', ContractController::class)->except('show');

    Route::get('installments/{contract}/create', [InstallmentController::class, 'create'])->name('installments.create');
    Route::post('installments/{contract}/store', [InstallmentController::class, 'store'])->name('installments.store');

    Route::get('receives/{contract}/create', [ReceiveController::class, 'create'])->name('receives.create');
    Route::post('receives/{contract}/store', [ReceiveController::class, 'store'])->name('receives.store');

    Route::get('checks', [CheckController::class, 'index'])->name('checks.index');
});
