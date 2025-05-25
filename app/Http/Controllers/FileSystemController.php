<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileSystemController extends Controller
{
    public function ManangeView()
    {
        $directories = Storage::disk('public')->directories();
        $data = [];
        foreach ($directories as $directory) {
            $files = Storage::disk('public')->files($directory);

            $data[] = [
                'directory' => $directory,
                'countFile' => count($files),
            ];
        }
        return view('home-page', [
            'directories' => $data
        ]);
    }

    public function createText()
    {
        $message = '';
        $status = '';
        $code = '';
        $data = "";

        try {
            $fileName = 'example01.txt';
            $path = "texts/$fileName";


            if (Storage::disk('public')->exists($path)) {
                $message = "Documento $fileName já existe.";
                $status = "Duplicated";
                $code = 409;
            } else {
                $content = "Esse é o exemplo 01....\n\nAqui temos mais conteúdo para o arquivo.\nVocê pode adicionar múltiplas linhas, texto explicativo, ou qualquer informação que quiser.\n\nLaravel facilita muito o armazenamento de arquivos!";
                Storage::disk('public')->put($path, $content);

                $message = "Documento $fileName gerado.";
                $status = "Created";
                $code = 201;
                $data = ['path' => $path];
            }

        } catch (\Exception $e) {
            $message = "Erro ao salvar o arquivo.";
            $status = "Error";
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
            $fileName = 'data01.json';
            $path = "json/$fileName";

            if (Storage::disk('public')->exists($path)) {
                $message = "Arquivo $fileName já existe.";
                $status = "Duplicated";
                $code = 409;
            } else {
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

                Storage::disk('public')->put($path, json_encode($json, JSON_PRETTY_PRINT));

                $message = "JSON $fileName gerado.";
                $status = "Created";
                $code = 201;
                $data = ['path' => $path];
            }

        } catch (\Exception $e) {
            $message = "Erro ao salvar JSON.";
            $status = "Error";
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function listDocumentOfDirectory(Request $request)
    {
        $message = '';
        $status = '';
        $code = '';
        $data = [];

        try {
            $directory = $request->input('directory', '');

            if (!Storage::disk('public')->exists($directory)) {
                $message = "Diretório '$directory' não encontrado.";
                $status = "Not Found";
                $code = 404;
            } else {
                $subdirectories = Storage::disk('public')->directories($directory);
                $files = Storage::disk('public')->files($directory);
                $fileData = array_map(function ($file) {
                    return [
                        'name' => basename($file),
                        'size_kb' => round(Storage::disk('public')->size($file) / 1024, 2),
                        'path' => $file,
                    ];
                }, $files);

                $directoryData = array_map(function ($dir) {
                    return [
                        'name' => basename($dir),
                        'path' => $dir,
                    ];
                }, $subdirectories);

                $data = [
                    'pasta' => $directory === '' ? '/' : $directory,
                    'subpastas' => $directoryData,
                    'arquivos' => $fileData,
                ];

                $message = "Conteúdo do diretório '$directory'.";
                $status = "Success";
                $code = 200;
            }
        } catch (\Exception $e) {
            $message = "Erro ao listar arquivos e pastas.";
            $status = "Error";
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function filterDocumentOfDirectory(Request $request)
    {
        $message = '';
        $status = '';
        $code = '';
        $data = [];

        try {
            $directory = $request->input('directorie', '');
            $filter = $request->input('filter', '');

            if (!Storage::disk('public')->exists($directory)) {
                $message = "Diretório '$directory' não encontrado.";
                $status = "Not Found";
                $code = 404;
            } else {
                // Subpastas imediatas
                $subdirectories = Storage::disk('public')->directories($directory);

                // Aplica filtro se fornecido
                $filteredDirs = array_filter($subdirectories, function ($dir) use ($filter) {
                    return !$filter || str_contains(basename($dir), $filter);
                });

                $directoryData = array_map(function ($dir) {
                    return [
                        'name' => basename($dir),
                        'path' => $dir,
                    ];
                }, $filteredDirs);

                // Arquivos imediatos
                $files = Storage::disk('public')->files($directory);

                $filteredFiles = array_filter($files, function ($file) use ($filter) {
                    return !$filter || str_contains(basename($file), $filter);
                });

                $fileData = array_map(function ($file) {
                    return [
                        'name' => basename($file),
                        'size_kb' => round(Storage::disk('public')->size($file) / 1024, 2),
                        'path' => $file,
                    ];
                }, $filteredFiles);

                $data = [
                    'pasta' => $directory === '' ? '/' : $directory,
                    'subpastas' => $directoryData,
                    'arquivos' => $fileData,
                ];

                $message = "Conteúdo do diretório '$directory' filtrado por '$filter'.";
                $status = "Success";
                $code = 200;
            }
        } catch (\Exception $e) {
            $message = "Erro ao listar arquivos e pastas.";
            $status = "Error";
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function deleteDirectory(Request $request)
    {
        $message = '';
        $status = '';
        $code = '';
        $data = "";

        try {
            $directory = $request->input('directorie', '');

            if (!Storage::disk('public')->exists($directory)) {
                $message = "Diretório '$directory' não encontrado.";
                $status = "Not Found";
                $code = 404;
            } else {
                Storage::deleteDirectory($directory);
                $message = "A pasta $directory foi deletada com sucesso.";
                $status = "Deleted";
                $code = 201;
                $data = '';
            }

        } catch (\Exception $e) {
            $message = "Erro ao salvar o arquivo.";
            $status = "Error";
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

}
