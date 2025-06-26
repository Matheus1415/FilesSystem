@extends('layouts.home-layout')

@section('title', 'Home')

@section('content')
    <main class="p-4">
        <div class="flex flex-col md:flex-row gap-x-2 gap-y-4 justify-center items-center md:items-start">
            <div class="w-9/12 md:w-3/12 flex flex-col gap-y-4">
                <x-card class="col-span-3">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Espaço total (Gb)
                    </h3>

                    <div class="flex items-center justify-center mb-2">
                        <p class="text-4xl text-center">
                            <span class="text-primary ado">{{ $totalFilesSizeGB }}</span>
                            <span>/</span>
                            <span>2</span>
                        </p>
                    </div>

                    {{-- <input type="range" readonly disabled value="{{ $totalFilesSizeGB }}" min="0" max="2" step="0.01" class="w-full"> --}}

                    {{-- <div class="flex items-center justify-center gap-4">
                        <x-button icon='icon-search'>
                            Details
                        </x-button>


                        <x-button icon='icon-upload' variant='primary'>
                            Upgrade
                        </x-button>
                    </div>   --}}
                </x-card>

                <x-card>
                    <div class="border-1 border-frost-50 rounded-md">
                        <div class="p-4">

                            <form action="{{ '/upload-form'}}" id="upload-form" class="dropzone" data-path="">
                                @csrf
                                <div class="dz-message flex flex-col items-center justify-center border-2 border-dashed border-frost/50 rounded p-8 bg-background-foreground text-frost transition hover:bg-frost/10">
                                    <i class="icon-upload text-5xl mb-4 text-primary"></i>
                                    <span class="text-lg text-center leading-5 font-bold">Solte os arquivos aqui</span>
                                    <span class="text-sm text-center leading-4.5 text-muted">Ou clique para escolher</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="w-9/12 flex flex-col gap-4">
                <x-card class="col-span-9">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Pastas
                    </h3>

                    <div class="grid grid-cols-3 gap-2">
                        <x-folder-button class="foldrs-select" folderName="Main"
                            data-pathfolder="/" filesAmount="{{$countFileMain}}"/>
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
                        </button>
                        <button
                            class="add-folder inline-block px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                            Criar pasta
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

@push('css')
    @vite(['resources/css/pages/home.css'])
@endpush