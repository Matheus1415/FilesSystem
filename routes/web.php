<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/',[FileController::class,'index'])->name('home');

Route::get('/storage_local_create',[FileController::class,'storageLocalCreate'])->name('storage.local.create');


//Posso carregar um documetno específico
Route::get('/doc',function(){
    $content = Storage::disk('public')->get('text.txt');
    echo $content;
});