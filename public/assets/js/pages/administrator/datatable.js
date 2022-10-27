
var table;
 
$(document).ready(function() {
    const url_datatable = $('#tb-administrator').attr('data-form-url-datatable');
   
    //datatables
    table = $('#tb-administrator').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": url_datatable,
            "type": "POST"
        },
        "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
       
    });
});