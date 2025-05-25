<?php

namespace App\Http\Controllers;

use App\Models\FileSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function GuzzleHttp\json_encode;

class FileSystemController extends Controller
{
    public function index()
    {
        $message = '';
        $status = '';
        $code = '';
        $data = "";
        try {
            $documents = FileSystem::all();

            $data = $documents;
            $message = "Todos os documentos.";
            $status = "All";
            $code = 200;
        } catch (\Exception $e) {
            $message = "Houve um erro ao tentar se comunicar com o servidor de dados";
            $status = $e;
            $code = 500;
        }
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function createText()
    {
        $message = '';
        $status = '';
        $code = '';
        $data = "";
        try {
            Storage::disk('public')->put('example01.txt', "Esse é o exemplo 01....\n\nAqui temos mais conteúdo para o arquivo.\nVocê pode adicionar múltiplas linhas, texto explicativo, ou qualquer informação que quiser.\n\nLaravel facilita muito o armazenamento de arquivos!");

            $documentDuplicated = FileSystem::where('name', 'example01')->count();

            if ($documentDuplicated > 0) {
                $message = "Documento example01 já foi gerado.";
                $status = "Duplicated";
                $code = 409;
            } else {
                $documentCreated = FileSystem::create([
                    'name' => 'example01',
                    'type' => 'document',
                    'path' => 'storage/example01.txt',
                ]);

                $data = $documentCreated;

                $message = "Documento example01 gerado.";
                $status = "Created";
                $code = 201;
            }
        } catch (\Exception $e) {
            $message = "Houve um erro ao tentar se comunicar com o servidor de dados";
            $status = $e;
            $code = 500;
        }
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function createJson()
    {
        $message = '';
        $status = '';
        $code = '';
        $data = "";
        try {
            $json = [
                ['name' => "João", 'email' => "joao@gmail.com"],
                ['name' => "Matheus", 'email' => "matheus@gmail.com"],
                ['name' => "Carlos", 'email' => "carlos@gmail.com"],
                ['name' => "Ana", 'email' => "ana.silva@gmail.com"],
                ['name' => "Bruna", 'email' => "bruna.oliveira@gmail.com"],
                ['name' => "Diego", 'email' => "diego.souza@gmail.com"],
                ['name' => "Fernanda", 'email' => "fernanda.lima@gmail.com"],
                ['name' => "Gabriel", 'email' => "gabriel.costa@gmail.com"],
                ['name' => "Juliana", 'email' => "juliana.martins@gmail.com"],
                ['name' => "Lucas", 'email' => "lucas.rocha@gmail.com"],
                ['name' => "Patrícia", 'email' => "patricia.mendes@gmail.com"],
                ['name' => "Rafael", 'email' => "rafael.ferreira@gmail.com"],
                ['name' => "Sofia", 'email' => "sofia.ramos@gmail.com"],
                ['name' => "Thiago", 'email' => "thiago.almeida@gmail.com"],
                ['name' => "Vinícius", 'email' => "vinicius.santos@gmail.com"],
            ];

            Storage::disk('public')->put('data01.json',json_encode($json));

            $documentDuplicated = FileSystem::where('name', 'data01')->count();

            if ($documentDuplicated > 0) {
                $message = "Documento example01 já foi gerado.";
                $status = "Duplicated";
                $code = 409;
            } else {
                $documentCreated = FileSystem::create([
                    'name' => 'data01',
                    'type' => 'json',
                    'path' => 'storage/data01.json',
                ]);

                $data = $documentCreated;

                $message = "Documento example01 gerado.";
                $status = "Created";
                $code = 201;
            }
        } catch (\Exception $e) {
            $message = "Houve um erro ao tentar se comunicar com o servidor de dados";
            $status = $e;
            $code = 500;
        }
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }
}
