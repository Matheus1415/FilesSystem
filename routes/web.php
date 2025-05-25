<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/',[FileController::class,'index'])->name('home');

//Criar arquivos
Route::get('/storage_local_create',[FileController::class,'storageLocalCreate'])->name('storage.local.create');
Route::get('/storage_local_append',[FileController::class,'storageLocalAppend'])->name('storage.local.append');
//Ler aquivos
Route::get('/storage_local_read',[FileController::class,'storageLocalRead'])->name('storage.local.read');
Route::get('/storage_local_read_multi',[FileController::class,'storageLocalReadMulti'])->name('storage.local.read.multi');

//Verifiando existencia dos arquivos
Route::get('/storage_local_check_file',[FileController::class,'storageLocalCheckFile'])->name('storage.local.check.file');

//Arquivos Json
Route::get('/storage_local_store_json',[FileController::class,'storageLocalStoreJson'])->name('storage.local.store.json');
Route::get('/storage_local_read_json',[FileController::class,'storageLocalReadJson'])->name('storage.local.read.json');

//Listar arquivos e deletando
Route::get('/storage_local_list',[FileController::class,'storageLocalList'])->name('storage.local.list');
Route::get('/storage_local_delete',[FileController::class,'storageLocalDelete'])->name('storage.local.delete');

//Criando e deletando pastas
Route::get('/storage_local_create_folder',[FileController::class,'storageLocalCreateFolder'])->name('storage.local.create.folder');
Route::get('/storage_local_delete_folder',[FileController::class,'storageLocalDeleteFolder'])->name('storage.local.delete.folder');

//Meta dados
Route::get('/storage_local_liste_files_metadados',[FileController::class,'storageLocalDeletlisteFolder'])->name('storage.local.list.files.metadata');


//Posso carregar um documetno específico
Route::get('/doc',function(){
    $content = Storage::disk('public')->get('text.txt');
    echo $content;
});


Route::view('/daniel', 'home-page');