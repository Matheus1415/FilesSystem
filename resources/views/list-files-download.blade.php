<x-main-layout>
    <div class="container">
        <p class="display-5 mt-5">Arquivos para Download</p>
        <hr>
        <div class="row">
            @foreach ($files as $file)
                <div class="col-12 card-p-2">
                    <ul>
                        <li>Name: {{ $file['name'] }}</li>
                        <li>Size: {{ $file['size'] }}</li>
                        {{-- <li>Download: <a href="{{$file['file_url']}}">Download</a></li> --}}
                        <li>Download: <a href="{{route('download',$file['file'])}}">Download</a></li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
