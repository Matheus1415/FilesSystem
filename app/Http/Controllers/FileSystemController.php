<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileSystemController extends Controller
{
    public function ManangeView()
    {
        $directories = Storage::disk('public')->directories();
        $data = [];
        $rootFiles = Storage::disk('public')->files('');
        $countFileMain = count($rootFiles);

        foreach ($directories as $directory) {
            $files = Storage::disk('public')->files($directory);

            $data[] = [
                'directory' => $directory,
                'countFile' => count($files),
            ];
        }
        return view('home-page', [
            'directories' => $data,
            'countFileMain' => $countFileMain,
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
            $path = "$fileName";


            if (Storage::disk('public')->exists($path)) {
                $message = "Documento $fileName já existe.";
                $status = "Duplicated";
                $code = 200;
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
            $path = "$fileName";

            if (Storage::disk('public')->exists($path)) {
                $message = "Arquivo $fileName já existe.";
                $status = "Duplicated";
                $code = 200;
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
        $code = 200;
        $data = [];

        try {
            $directory = $request->input('directory', '');

            if ($directory !== '' && !Storage::disk('public')->exists($directory)) {
                $message = "Diretório '$directory' não encontrado.";
                $status = "Not Found";
                $code = 404;
            } else {
                Carbon::setLocale('pt_BR');

                $folders = Storage::disk('public')->directories($directory);
                $files = Storage::disk('public')->files($directory);

                foreach ($folders as $folder) {
                    $data[] = [
                        'name' => basename($folder),
                        'path' => $folder,
                        'type' => 'folder',
                        'size_kb' => null,
                        'last_modified' => null,
                    ];
                }

                foreach ($files as $file) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $type = 'other';

                    if (in_array($extension, ['txt', 'log', 'md', 'xml', 'csv'])) {
                        $type = 'text';
                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'])) {
                        $type = 'image';
                    } elseif ($extension === 'pdf') {
                        $type = 'pdf';
                    } elseif ($extension === 'json') {
                        $type = 'json';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'mpeg'])) {
                        $type = 'video';
                    }

                    $data[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'type' => $type,
                        'size_kb' => round(Storage::disk('public')->size($file) / 1024, 2),
                        'last_modified' => Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file))->diffForHumans(),
                    ];
                }

                $message = "Conteúdo do diretório '$directory'.";
                $status = "Success";
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
        $code = 200;
        $data = "";

        try {
            $directory = $request->path;

            if (!Storage::disk('public')->exists($directory)) {
                $message = "Diretório '$directory' não encontrado.";
                $status = "Not Found";
                $code = 404;
            } else {
                Storage::disk('public')->deleteDirectory($directory);
                $message = "A pasta '$directory' foi deletada com sucesso.";
                $status = "Deleted";
                $code = 200;
            }

        } catch (\Exception $e) {
            $message = "Erro ao deletar a pasta.";
            $status = "Error";
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }


    public function deleteFile(Request $request)
    {
        $path = $request->input('path');

        if (!$path) {
            return response()->json([
                'message' => 'Caminho do arquivo não fornecido.',
                'status' => 'Error',
            ], 400);
        }

        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);

                return response()->json([
                    'message' => "Arquivo '$path' deletado com sucesso.",
                    'status' => 'Deleted',
                ], 200);
            } else {
                return response()->json([
                    'message' => "Arquivo '$path' não encontrado.",
                    'status' => 'Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar o arquivo.',
                'status' => 'Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadFile(Request $request)
    {        
        
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return response()->json(['erro' => 'Arquivo inválido.'], 422);
        }   

        $path = $request['path'];
        $file = $request['file'];

        $fileName = $file->getClientOriginalName();

        $filePath = Storage::disk('public')->putFileAs($path, $file, $fileName);

        if (!$filePath) {
            return response([
                'message' => 'Occoreu um erro ao tentar salvar seu arquivo tente novamente mais tarde'
            ]);
        }

        return response([
            'message' => 'Arquivo criado com suceeso'
        ], 200);
    }

    public function downloadFile(Request $request)
    {
        $filePath = $request->path;
        if (empty($filePath) || Str::contains($filePath, ['..', './', '\\'])) {
            return response()->json([
                'message' => 'Caminho inválido ou não especificado.',
                'status' => 'Invalid',
            ], 400);
        }

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json([
                'message' => "Arquivo '$filePath' não encontrado.",
                'status' => 'Not Found',
            ], 404);
        }

        $fullPath = Storage::disk('public')->path($filePath);
        return response()->download($fullPath);
    }

    public function getJsonContent(Request $request)
    {
        $path = $request->query('path');

        if (empty($path) || Str::contains($path, ['..', './'])) {
            return response()->json(['message' => 'Caminho inválido.'], 400);
        }

        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['message' => 'Arquivo não encontrado.'], 404);
        }

        $content = Storage::disk('public')->get($path);

        try {
            return response()->json(json_decode($content, true));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Conteúdo JSON inválido.'], 422);
        }
    }
}
