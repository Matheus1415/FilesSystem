import $ from "jquery";
import DataTable from "datatables.net";

$(document).ready(function () {
    $("#myTable").DataTable({
        ajax: {
            url: "/list/directorie",
            dataSrc: function (json) {
                return json.data.arquivos;
            },
        },
        columns: [
            { data: "name", title: "Nome" },
            { data: "data", title: "Data", defaultContent: "—" },
            {
                data: "size_kb",
                title: "Tamanho",
                render: function (data) {
                    return data ? data + "kb" : "—";
                },
            },
            {
                data: null,
                title: "Ações",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
            <button class="h-4 w-4 font-semibold cursor-pointer text-red-500" title="Excluir">
              <i class="icon-x"></i>
            </button>
            <button class="h-4 w-4 font-semibold cursor-pointer text-blue-500" title="Editar">
              <i class="icon-pencil"></i>
            </button>
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
});
