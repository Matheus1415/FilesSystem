import $ from "jquery";
import DataTable from "datatables.net";
import Dropzone from "dropzone";

$(document).ready(function () {
    let folderSelect = "/";

    const table = $("#myTable").DataTable({
        ajax: {
            url: "/list/directorie",
            dataSrc: function (json) {
                return json?.data || [];
            },
            data: function (d) {
                d.directory = folderSelect;
            },
        },
        columns: [
            {
                data: "name",
                title: "Nome",
                render: function (data, type, row) {
                    let icon = "";
                    switch (row.type) {
                        case "folder":
                            icon =
                                '<i class="icon-folder text-yellow-500 mr-2"></i>';
                            break;
                        case "text":
                            icon =
                                '<i class="icon-file-text text-green-500 mr-2"></i>';
                            break;
                        case "image":
                            icon =
                                '<i class="icon-file-image text-blue-500 mr-2"></i>';
                            break;
                        case "pdf":
                            icon =
                                '<i class="icon-file-text text-red-500 mr-2"></i>';
                            break;
                        case "csv":
                            icon =
                                '<i class="icon-file-csv text-indigo-500 mr-2"></i>';
                            break;
                        case "json":
                            icon =
                                '<i class="icon-file-code text-purple-500 mr-2"></i>';
                            break;
                        case "video":
                            icon =
                                '<i class="icon-clapperboard text-emerald-500 mr-2"></i>';
                            break;
                        default:
                            icon =
                                '<i class="icon-file text-gray-500 mr-2"></i>';
                    }
                    return `${icon}<span>${data}</span>`;
                },
            },
            {
                data: "size_kb",
                title: "Tamanho",
                render: function (data, type, row) {
                    if (data == null) {
                        return "-";
                    } else {
                        return `${data}kb`;
                    }
                },
            },
            {
                data: "size_kb",
                title: "Tamanho",
                render: function (data, type, row) {
                    return row.type === "file" && data
                        ? `${data.size_kb}kb`
                        : "—";
                },
            },
            {
                data: null,
                title: "Ações",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.type === "folder") {
                        return `
                        <button data-path="${row.path}" class="delete-btn-folder text-red-500 hover:text-red-700" title="Excluir">
                            <i class="icon-x"></i>
                        </button>
                        <button data-pathfolder="${row.path}" class="folder-select text-blue-500 hover:text-blue-700">
                            <i class="icon-arrow-right"></i>
                        </button>
                    `;
                    }

                    return `
                    <div class="flex gap-2">
                        <button data-path="${row.path}" class="delete-btn-file text-red-500 hover:text-red-700" title="Excluir">
                            <i class="icon-x"></i>
                        </button>
                        <button data-path="${row.path}" class="edit-btn text-blue-500 hover:text-blue-700" title="Editar">
                            <i class="icon-pencil"></i>
                        </button>
                    </div>
                `;
                },
            },
        ],
        responsive: true,
        language: {
            searchPlaceholder: "Filtrar...",
            sLengthMenu: "_MENU_ registros por página",
            sSearch: "",
            paginate: {
                previous: "Anterior",
                next: "Próximo",
            },
        },
        order: [[0, "asc"]],
    });

    $(document).on("click", ".folder-select", function () {
        const path = $(this).data("pathfolder");
        $(".folder-select")
            .removeClass(
                "border-primary bg-primary text-background-foreground hover:bg-primary/90"
            )
            .addClass("text-frost hover:bg-frost/5");
        let selectedFolderId = $("#" + CSS.escape(path));
        if (selectedFolderId.length > 0) {
            selectedFolderId
                .addClass(
                    "border-primary bg-primary text-background-foreground hover:bg-primary/90"
                )
                .removeClass("text-frost");
        }

        $(this)
            .addClass(
                "border-primary bg-primary text-background-foreground hover:bg-primary/90"
            )
            .removeClass("text-frost");

        folderSelect = path;
        table.ajax.reload(null, false);
    });

    $(document).on("click", ".add-text", function () {
        $.ajax({
            url: "/create/text",
            method: "GET",
            success: function (response) {
                if (response.status === "Duplicated") {
                    Swal.fire({
                        title: "Documento Duplicado",
                        text: response.message,
                        icon: "warning",
                    });
                } else {
                    Swal.fire({
                        title: "Documento Criado",
                        text: response.message,
                        icon: "success",
                    });

                    table.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Erro na requisição:",
                    xhr.responseJSON?.message || error
                );
            },
        });
    });

    $(document).on("click", ".add-json", function () {
        $.ajax({
            url: "/create/json",
            method: "GET",
            success: function (response) {
                if (response.status === "Duplicated") {
                    Swal.fire({
                        title: "Documento Duplicado",
                        text: response.message,
                        icon: "warning",
                    });
                } else {
                    Swal.fire({
                        title: "Documento Criado",
                        text: response.message,
                        icon: "success",
                    });

                    table.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Erro na requisição:",
                    xhr.responseJSON?.message || error
                );
            },
        });
    });

    $(document).on("click", ".delete-btn-file", function () {   
        const path = $(this).data("path");

        Swal.fire({
            title: "Tem certeza?",
            text: `Deseja realmente deletar o arquivo "${path}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, deletar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            const path = $(this).data("path");

            let formData = new FormData();
            formData.append("path", path);
            formData.append(
                "_token",
                $('meta[name="csrf-token"]').attr("content")
            );

            if (result.isConfirmed) {
                $.ajax({
                    url: "/delete/file",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === "Not Found") {
                            Swal.fire({
                                title: "Pasta não encontrada",
                                text: response.message,
                                icon: "waring",
                            });
                        } else {
                            Swal.fire({
                                title:
                                    response.status === "Deleted"
                                        ? "Arquivo Excluído"
                                        : "Erro",
                                text: response.message,
                                icon:
                                    response.status === "Deleted"
                                        ? "success"
                                        : "error",
                            });
                            if (response.status === "Deleted") {
                                table.ajax.reload(null, false);
                            }
                        }
                    },
                    error: function (xhr) {
                        console.error(
                            "Erro na requisição:",
                            xhr.responseJSON?.message || xhr.statusText
                        );
                    },
                });
            }
        });
    });

    $(document).on("click", ".delete-btn-folder", function () {
        const path = $(this).data("path");

        Swal.fire({
            title: "Tem certeza?",
            text: `Deseja realmente deletar a pasta "${path}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, deletar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            const path = $(this).data("path");

            let formData = new FormData();
            formData.append("path", path);
            formData.append(
                "_token",
                $('meta[name="csrf-token"]').attr("content")
            );

            if (result.isConfirmed) {
                $.ajax({
                    url: "/delete/directorie",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === "Not Found") {
                            Swal.fire({
                                title: "Pasta não encontrada",
                                text: response.message,
                                icon: "waring",
                            });
                        } else {
                            Swal.fire({
                                title:
                                    response.status === "Deleted"
                                        ? "Arquivo Excluído"
                                        : "Erro",
                                text: response.message,
                                icon:
                                    response.status === "Deleted"
                                        ? "success"
                                        : "error",
                            });
                            if (response.status === "Deleted") {
                                table.ajax.reload(null, false);
                            }
                        }
                    },
                    error: function (xhr) {
                        console.error(
                            "Erro na requisição:",
                            xhr.responseJSON?.message || xhr.statusText
                        );
                    },
                });
            }
        });
    });
});

let myDropzone = new Dropzone("#upload-form", {
    url: "/upload", // endpoint
    maxFiles: 5, // limite de arquivos
    maxFilesize: 1, // MB
    acceptedFiles: "image/*", // tipos aceitos
    disablePreviews: true,

    dictDefaultMessage: null,
    dictRemoveFile: "Remover",
    dictMaxFilesExceeded: "Você só pode enviar até 5 arquivos.",
});

myDropzone.on("addedfile", (file) => {
    console.log(`File added: ${file.name}`);
});

$(document).ready(() => {
    console.log(myDropzone);
});
