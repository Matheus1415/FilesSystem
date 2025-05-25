<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileSystemController;

Route::get('/',[FileSystemController::class,'ManangeView'])->name('index');
Route::get('/create/text',[FileSystemController::class,'createText'])->name('create.text');
Route::get('/create/json',[FileSystemController::class,'createJson'])->name('create.json');
Route::get('/list/directorie',[FileSystemController::class,'listDocumentOfDirectory'])->name('list.directorie');
Route::get('/list/directorie/filter',[FileSystemController::class,'filterDocumentOfDirectory'])->name('list.directorie.file');

