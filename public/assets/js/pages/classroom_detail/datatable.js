
var table;
 
$(document).ready(function() {
   
    const url_datatable = $('#tb-classroom_detail').attr('data-form-url-datatable');
    const classroom = $('#tb-classroom_detail').data('classroom');
   
    table = $('#tb-classroom_detail').DataTable({ 
        
        "processing": true, 
        "serverSide": true,
        "autoWidth": false,
        "order": [], 
        "ajax": {
            "url": url_datatable,
            "type": "POST",
            "data":{ classroom: classroom} ,
        },
        "columnDefs": [
            { 
                // "render": createManageBtn, 
                //first column / numbering column
                "targets": [ 0 ], 
                "orderable": false, 
                "className": 'select-checkbox',
                "checkboxes": {
                    'selectRow': true
                 },
            },
        ],
       "select": {
            style: 'multi',
            // style: 'os',
            selector: 'td:first-child'
        },
        
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            // 'pageLength',
            {
                text: 'Add New',
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    
                    const form_id = $('#form_modal_classroom_detail');
                    const url = $(form_id).data('url');
                    $(form_id).attr('action', url); 

                    reset_modal_classroom_detail('Form Add Classroom Detail');
                    
                },
                customize: function ( win ) { 
                    $(win.document.body).css('background-color', '#ff0000'); 
                }
            },
        ],
       
    });
});