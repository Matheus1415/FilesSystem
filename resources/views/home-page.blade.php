@extends('layouts.home-layout')

@section('title', 'Home')

@section('content')
    <main class="p-4">
        <div class="flex flex-col md:flex-row gap-x-2 gap-y-4 justify-center items-center md:items-start">
            <div class="w-9/12 md:w-3/12 flex flex-col gap-y-4">
                <x-card class="col-span-3">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Account storage
                    </h3>

                    <div class="bg-primary h-40 mb-2"></div>

                    <div class="flex items-center justify-center gap-4">
                        <x-button icon='icon-search'>
                            Details
                        </x-button>


                        <x-button icon='icon-upload' variant='primary'>
                            Upgrade
                        </x-button>
                    </div>
                </x-card>

                <x-card>
                    <div class="border-1 border-frost-50 rounded-md">
                        <div class="p-4">
                            <x-button class="text-sm !w-fit">
                                Upload
                            </x-button>
                        </div>

                        <hr>

                        <div class="p-4">

                            <form action="/upload-form" id="upload-form" class="dropzone">
                                <div
                                    class="dz-message flex flex-col items-center justify-center border-2 border-dashed border-frost/50 rounded p-8 bg-background-foreground text-frost transition hover:bg-frost/10">
                                    <i class="icon-upload text-5xl mb-4 text-primary"></i>
                                    <span class="text-lg font-bold">Solte os arquivos aqui</span>
                                    <span class="text-sm text-muted">Ou clique para escolher</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="w-9/12 flex flex-col gap-4">
                <x-card class="col-span-9">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Folders
                    </h3>

                    <div class="grid grid-cols-3 gap-2">
                        <x-folder-button class="foldrs-select" folderName="Main"
                            data-pathfolder="/" filesAmount="{{$countFileMain}}" />
                        @foreach ($directories as $directorie)
                            <x-folder-button id="{{ $directorie['directory'] }}" class="foldrs-select" folderName="{{ $directorie['directory'] }}"
                                data-pathfolder="{{ $directorie['directory'] }}"
                                filesAmount="{{ $directorie['countFile'] }}" />
                        @endforeach
                    </div>
                </x-card>

                <x-card>
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Lista de Arquivos
                    </h3>

                    <div class="flex space-x-4">
                        <button
                            class="add-text inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Criar Arquivo example
                        </button>
                        <button
                            class="add-json inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Criar json
                        </button>
                    </div>


                    <table id="myTable">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Data</th>
                                <th class="px-4 py-2">Tamanho</th>
                                <th class="px-4 py-2 text-center">Ações</th>
                            </tr>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </x-card>
            </div>

        </div>
    </main>
@endsection
