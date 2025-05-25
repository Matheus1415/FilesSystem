<x-main-layout>
    <div class="container">
        <p class="display-5 mt-5">Arquivos com metaDados</p>
        <hr>
        <div class="row">
            @foreach ($files as $file )
                <div class="col-12 card-p-2">
                    <ul>
                        <li>Name: {{$file['name']}}</li>
                            <li>Size: {{$file['size']}}</li>
                            <li>Last Modified: {{$file['last_modified']}}</li>
                            <li>Mime Type: {{$file['mime_type']}}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>