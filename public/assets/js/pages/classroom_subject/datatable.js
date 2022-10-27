
var table;
 
$(document).ready(function() {
   
    const url_datatable = $('#tb-classroom_subject').attr('data-form-url-datatable');
   
    table = $('#tb-classroom_subject').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "select": true,
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