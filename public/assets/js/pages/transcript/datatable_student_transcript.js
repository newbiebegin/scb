
var table;
 
$(document).ready(function() {
   
    const url_datatable = $('#tb-transcript').attr('data-form-url-datatable');
   
    table = $('#tb-transcript').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "select": true,
        "ajax": {
            "url": url_datatable,
            "type": "POST",
            
            "data": function(data){
                data.search_name = $('#name').val();
                data.search_nis = $('#nis').val();
                data.search_classroom = $('#classroom').val();
                data.search_school_year = $('#school_year').val();
                data.search_semester = $('#semester').val();
            }
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

    // $('#name').on('change', function(e) {
    //     table.draw();
    // });

    $('#btn_search').on('click', function(e) {
        table.draw();
    });

});