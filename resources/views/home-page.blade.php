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

            <div class="w-9/12">
                <x-card class="col-span-9">
                    <h3 class="capitalize text-lg text-frost font-semibold mb-2">
                        Folders
                    </h3>
                    
                    <div class="grid grid-cols-3 gap-2">
                        
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                        <x-folder-button folderName='daniel ativo' fileAmount='22' isActive class="active"/>
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                        <x-folder-button folderName='daniel' fileAmount='22'/>
                    </div>
                </x-card>
            </div>


        </div>
    </main>
@endsection