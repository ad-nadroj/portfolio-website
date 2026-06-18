<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/portfolio');
});

Route::view('/portfolio', 'portfolio.index');

Route::view('/poc', 'portfolio.data-engineering');
Route::view('/poc/system-architecture', 'portfolio.system-architecture');
Route::view('/poc/agentic-framework', 'portfolio.agentic-framework');
