<x-main-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="text-center display-3">Laboratorio de FileSystem</div>
                <hr>
                <div class="d-flex gap-5 mb-5">
                    <a href="{{ route('storage.local.create') }}" class="btn btn-primary">Criar arquivo no storage
                        Local</a>
                    <a href="{{ route('storage.local.append') }}" class="btn btn-primary">Criar arquivo no storage
                        Append</a>
                    <a href="{{ route('storage.local.read') }}" class="btn btn-primary">Ler conteúdo do storage local</a>
                    <a href="{{ route('storage.local.read.multi') }}" class="btn btn-primary">Ler arquivo com multiplas
                        linhas</a>
                </div>

                <div class="d-flex gap-5 mb-5">
                    <a href="{{ route('storage.local.check.file') }}" class="btn btn-primary">Verificar existência de
                        arquivos</a>
                    <a href="{{ route('storage.local.store.json') }}" class="btn btn-primary">Criando arquivo Json</a>
                    <a href="{{ route('storage.local.read.json') }}" class="btn btn-primary">Lendo arquivo Json</a>
                    <a href="{{ route('storage.local.list') }}" class="btn btn-primary">Listar arquivos</a>
                    <a href="{{ route('storage.local.delete') }}" class="btn btn-primary">Eliminar arquivos</a>
                </div>

                <div class="d-flex gap-5 mb-5">
                    <a href="{{ route('storage.local.create.folder') }}" class="btn btn-primary">Adicionar Pasta</a>
                    <a href="{{ route('storage.local.delete.folder') }}" class="btn btn-primary">Deletar Pasta</a>
                    <a href="{{ route('storage.local.list.files.metadata') }}" class="btn btn-primary">Listar
                        MetaDados</a>
                    <a href="{{ route('storage.local.list.download') }}" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
        <div class="col">
            <form action="{{ route('storage.local.list.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Arquivo</label>
                    <input type="file" name="arquivo" id="arquivo" class="form-control">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5"> Enviar</button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>
