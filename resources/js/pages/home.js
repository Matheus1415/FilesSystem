import $ from 'jquery';
import DataTable from 'datatables.net';

$(document).ready(function () {
    $('#myTable').DataTable({
        info: false,
        ordering: false,
        paging: false
    });
});