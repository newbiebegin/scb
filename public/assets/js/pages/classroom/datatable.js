
var table;
 
$(document).ready(function() {
    // var ddnDatatable =  $('#Template1').html();
    // alert(ddnDatatable);

    const url_datatable = $('#tb-classroom').attr('data-form-url-datatable');
   
    table = $('#tb-classroom').DataTable({ 
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
                // "render": createManageBtn, 
                //first column / numbering column
                "targets": [ 0 ], 
                "orderable": false, 
            },
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
       
    });

    // $('#tb-classroom').on( 'click', 'tbody td', function () {
    //     table.cell( this ).edit();
    // } );

    // Inline editing
			var oldValue = null;
			$(document).on('dblclick', '.tbody td', function(){
				oldValue = $(this).html();
				// $(this).removeClass('editable');	// to stop from making repeated request
				
				$(this).html('<input type="text" style="width:150px;" class="update" value="'+ oldValue +'" />');
				$(this).find('.update').focus();
			});

});