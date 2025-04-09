<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [env('APP_NAME', 'Laravel') => app()->version()];
});


Route::get('/api-documentation', function () {
    return view('swagger.index');
});
