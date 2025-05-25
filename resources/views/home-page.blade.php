@extends('layouts.home-layout')

@section('title', 'Home')

@section('content')
    <main class="p-4">
        <div class="grid grid-cols-12 gap-4">
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
            <x-card class="col-span-9">dani</x-card>
        </div>
    </main>
@endsection