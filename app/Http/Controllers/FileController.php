<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function storageLocalCreate()
    {
        Storage::put('file1.txt', 'Conteúdo do ficheiro 1');
        return 'Arquivo criado com sucesso.';
    }

}
