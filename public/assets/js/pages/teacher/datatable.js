
var table;
 
$(document).ready(function() {
    const url_datatable = $('#tb-teacher').attr('data-form-url-datatable');
   
    //datatables
    table = $('#tb-teacher').DataTable({ 
        //Feature control the processing indicator.
        "processing": true, 
        //Feature control DataTables' server-side processing mode.
        "serverSide": true, 
        //Initial no order.
        "order": [], 
        "select": true,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": url_datatable,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                // "render": createManageBtn, 
                //first column / numbering column
                "targets": [ 0 ], 
                //set not orderable
                "orderable": false, 
            },
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
       
    });
});

// function createManageBtn() {
//     return '<button id="manageBtn" type="button" onclick="myFunc()" class="btn btn-success btn-xs">Edit</button>';
// }
// function myFunc() {
    
//     var currentTD = $(this).parents('tr').find('td');
    
//     console.log("Button was clicked!!!");
// }