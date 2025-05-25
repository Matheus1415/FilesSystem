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
                            <x-folder-button folderName="{{$directorie['directory']}}" filesAmount="{{$directorie['countFile']}}" />
                        @endforeach
                    </div>
                </x-card>

                <x-card>
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Recent uploads
                    </h3>

                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Tamanho</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>daniel</td>
                                <td>otem</td>
                                <td>12kb</td>
                                <td class="space-x-4">
                                    <button class="h-4 w-4 font-semibold cursor-pointer text-red-500">
                                        <i class="icon-x"></i>
                                    </button>
                                    <button class="h-4 w-4 font-semibold cursor-pointer text-blue-500">
                                        <i class="icon-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </x-card>
            </div>


        </div>
    </main>
@endsection
