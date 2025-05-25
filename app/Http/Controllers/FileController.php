<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function storageLocalCreate()
    {
        // # Criar um arquivo no local definido como 'public' em config/filesystems.php
        Storage::put('file1.txt', 'Conteúdo do ficheiro 1');

        // # Criar um arquivo especificando explicitamente o disco 'public'
        Storage::disk('public')->put('file2.txt', 'Conteúdo do ficheiro 2');

        return redirect()->route('home');
    }

    public function storageLocalAppend()
    {
        // # Adicionar conteúdo a um arquivo (modo append) - usando o disco padrão
        Storage::append('file3.txt', Str::random(100));

        // # Adicionar conteúdo a um arquivo especificando o disco 'public'
        Storage::disk('public')->append('file3.txt', Str::random(100));

        return redirect()->route('home');
    }

    public function storageLocalRead()
    {
        // # Ler o conteúdo de um arquivo usando o disco padrão
        $content1 = Storage::get('file1.txt');
        echo "<p>Conteúdo file1.txt (default): $content1</p>";

        // # Ler o conteúdo de um arquivo no disco 'public'
        $content2 = Storage::disk('public')->get('file2.txt');
        echo "<p>Conteúdo file2.txt (public): $content2</p>";
    }

    public function storageLocalReadMulti()
    {
        // # Lendo conteúdo com múltiplas linhas do arquivo
        $lines = Storage::disk('public')->get('file3.txt');
        $lines = explode(PHP_EOL, $lines);

        foreach ($lines as $line) {
            echo "<p>$line</p>";
        }
    }

    public function storageLocalCheckFile()
    {
        // # Verificando se existe o arquivo no disco 'public'
        $exists = Storage::disk('public')->exists('file2.txt');
        echo $exists ? "O arquivo file2.txt existe" : "O arquivo file2.txt não existe";
        echo '<br>';

        // # Verificando se um arquivo está em falta (missing)
        if (Storage::disk('public')->missing('file100.txt')) {
            echo "O arquivo file100.txt não existe";
        } else {
            echo "O arquivo file100.txt existe";
        }
    }

    public function storageLocalStoreJson()
    {
        $data = [
            ['name' => "João", 'email' => "joao@gmail.com"],
            ['name' => "Matheus", 'email' => "matheus@gmail.com"],
            ['name' => "Carlos", 'email' => "carlos@gmail.com"],
        ];

        // # Criar e salvar um arquivo JSON no disco padrão
        Storage::put('data.json', json_encode($data));

        // # Criar e salvar um arquivo JSON no disco 'public'
        Storage::disk('public')->put('data_public.json', json_encode($data));
    }

    public function storageLocalReadJson()
    {
        // # Lendo arquivo JSON no disco padrão
        $data1 = json_decode(Storage::get('data.json'), true);
        echo "<h4>Dados do data.json:</h4>";
        echo '<pre>';
        print_r($data1);

        // # Lendo arquivo JSON no disco 'public'
        $data2 = json_decode(Storage::disk('public')->get('data_public.json'), true);
        echo "<h4>Dados do data_public.json:</h4>";
        echo '<pre>';
        print_r($data2);
    }

    public function storageLocalList()
    {
        // # Listando todos os arquivos na raiz do disco 'public'
        $files = Storage::disk('public')->files();
        echo "<h4>Arquivos na raiz de 'public':</h4>";
        echo '<pre>';
        print_r($files);

        // # Listando arquivos dentro de uma pasta específica (ex: 'projects')
        $projectFiles = Storage::files('projects');
        echo "<h4>Arquivos em 'projects/':</h4>";
        echo '<pre>';
        print_r($projectFiles);

        // # Listando arquivos dentro diretorio específico 
        $projectFiles = Storage::disk('local')->directories();
        echo "<h4>Listando so diretorio local :</h4>";
        echo '<pre>';
        print_r($projectFiles);

        // # Listando arquivos dentro diretorio específico 
        $projectFiles = Storage::disk('local')->files(null, true);
        echo "<h4>Listando os arquivo de todas as pastas dentro de app :</h4>";
        echo '<pre>';
        print_r($projectFiles);
    }

    public function storageLocalDelete()
    {
        // # Deletar um arquivo
        Storage::delete('file1.txt');

        // # Deletar todos os arquivo s uma pasta
        // Storage::delete(Storage::files('projects'));
        echo "Arquivo removido com sucesso.";
    }

    public function storageLocalCreateFolder()
    {
        // # Criando a pasta dentro de APP
        Storage::makeDirectory('documents');

        // # Criando a pasta dentro de outras pasta
        Storage::makeDirectory('documents/teste');
    }

    public function storageLocalDeleteFolder()
    {
        // # Deletando uma pasta
        // Storage::deleteDirectory('documents');

        // # Deletando uma pasta dentro de outra pasta
        Storage::deleteDirectory('documents/teste');
    }

    public function listFilesWithMetaData()
    {
        $list_files = Storage::allFiles();

        $files = [];

        foreach ($list_files as $file) {
            $files[] = [
                'name' => $file,
                'size' => round(Storage::size($file) / 1024, 2) . 'Kb',
                'last_modified' => Carbon::createFromTimestamp(Storage::lastModified($file)),
                'mime_type' => Storage::mimeType($file),
            ];
        }

        return view('list-metadata', ['files' => $files]);
    }

    public function listFilesForDownLoad()
    {
        $list_files = Storage::allFiles();
        $files = [];

        foreach ($list_files as $file) {
            $files[] = [
                'name' => $file,
                'size' => round(Storage::size($file) / 1024, 2) . 'Kb',
                // 'file_url' => Storage::url($file),
                'file' => basename($file),
            ];
        }

        return view('list-files-download', ['files' => $files]);
    }

    public function upload(Request $request)
    {
        // # Carregando o arquivo na pasta uplaod
        // $request->file('arquivo')->store('/upload');

        // # Caregndo o arquivo renomeado
        $request->file('arquivo')->storeAs('/public',$request->file('arquivo')->getClientOriginalName());
    }
}
