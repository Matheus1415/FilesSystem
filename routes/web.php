<?php

use App\Http\Controllers\FileSystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[FileSystemController::class,'index'])->name('index');
Route::get('/create/text',[FileSystemController::class,'createText'])->name('create.text');
Route::get('/create/json',[FileSystemController::class,'createJson'])->name('create.json');