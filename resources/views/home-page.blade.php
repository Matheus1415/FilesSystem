@extends('layouts.home-layout')

@section('title', 'Home')

@section('content')
    <main class="p-4">
        <div class="flex gap-x-2 justify-center">
            <div class="w-3/12 flex flex-col gap-y-4">
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
            </div>

            <div class="w-9/12 flex flex-col gap-4">
                <x-card class="col-span-9">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Folders
                    </h3>

                    <div class="grid grid-cols-3 gap-2">
                        @foreach ($directories as $directorie)
                            <x-folder-button folderName="{{ $directorie['directory'] }}"
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
