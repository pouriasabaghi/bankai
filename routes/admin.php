<?php

use Illuminate\Support\Facades\Route;


Route::group([],function(){
    Route::get('/dashboard', fn()=> view('admin.master'));
});

Route::get('/test', function () {
    echo "hello world";
});
