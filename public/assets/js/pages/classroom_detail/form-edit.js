var reset_modal_classroom_detail;

$(document).ready(function() {
 
    const form_modal_classroom = $('#form_modal_classroom').attr('data-form');
    const form_modal_classroom_id = $('#form_modal_classroom').val();
    const form_modal_url_autocomplete_classroom = $('#form_modal_classroom').attr('data-form-autocomplete-url');
 
    const form_modal_school_year = $('#form_modal_school_year').attr('data-form');
    const form_modal_school_year_id = $('#form_modal_school_year').val();
    const form_modal_url_autocomplete_school_year = $('#form_modal_school_year').attr('data-form-autocomplete-url');

    const form_modal_head_class_name = $('#form_modal_head_class').attr('data-form');
    const form_modal_head_class_id = $('#form_modal_head_class').val();
    const form_modal_url_autocomplete_head_class = $('#form_modal_head_class').attr('data-form-autocomplete-url');

    const form_modal_homeroom_teacher_name = $('#form_modal_homeroom_teacher').attr('data-form');
    const form_modal_homeroom_teacher_id = $('#form_modal_homeroom_teacher').val();
    const form_modal_url_autocomplete_homeroom_teacher = $('#form_modal_homeroom_teacher').attr('data-form-autocomplete-url');
 
    $('#form_modal_classroom-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                
                $.ajax(
                    form_modal_url_autocomplete_classroom,
                    {
                        data: { 'keyword': qry},
                        dataType:"json",
                    }
                ).done(function (res) {
                    callback(res.results)
                });
            },
        }
    });

    if(form_modal_classroom_id != '' && form_modal_classroom != '')
    {
        $('#form_modal_classroom-select').autoComplete('set', { value: form_modal_classroom_id, id: form_modal_classroom_id, text: form_modal_classroom });
    }

    $('#form_modal_classroom-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#form_modal_classroom').val(i.id);

            var data_parsley_id = $('#form_modal_classroom').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#form_modal_classroom').val('');
        }
    });
 
    $('#form_modal_school_year-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                
                $.ajax(
                    form_modal_url_autocomplete_school_year,
                    {
                        data: { 'keyword': qry},
                        dataType:"json",
                    }
                ).done(function (res) {
                    callback(res.results)
                });
            },
        }
    });

    if(form_modal_school_year_id != '' && form_modal_school_year != '')
    {
        $('#form_modal_school_year-select').autoComplete('set', { value: form_modal_school_year_id, id: form_modal_school_year_id, text: form_modal_school_year });
    }

    $('#form_modal_school_year-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#form_modal_school_year').val(i.id);

            var data_parsley_id = $('#form_modal_school_year').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#form_modal_school_year').val('');
        }
    });

    $('#form_modal_head_class-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    form_modal_url_autocomplete_head_class,
                    {
                        data: { 'keyword': qry},
                        dataType:"json",
                    }
                ).done(function (res) {
                    callback(res.results)
                });
            },
        }
    });

    if(form_modal_head_class_id != '' && form_modal_head_class_name != '')
    {
        $('#form_modal_head_class-select').autoComplete('set', { value: form_modal_head_class_id, id: form_modal_head_class_id, text: form_modal_head_class_name });
    }

    $('#form_modal_head_class-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#form_modal_head_class').val(i.id);

            var data_parsley_id = $('#form_modal_head_class').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#form_modal_head_class').val('');
        }
    });

    $('#form_modal_homeroom_teacher-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    form_modal_url_autocomplete_homeroom_teacher,
                    {
                        data: { 'keyword': qry},
                        dataType:"json",
                    }
                ).done(function (res) {
                    callback(res.results)
                });
            },
        }
    });
    
    if(form_modal_homeroom_teacher_id != '' && form_modal_homeroom_teacher_name !=''){
        $('#form_modal_homeroom_teacher-select').autoComplete('set', { value: form_modal_homeroom_teacher_id, id: form_modal_homeroom_teacher_id, text: form_modal_homeroom_teacher_name });
    }

    $('#form_modal_homeroom_teacher-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#form_modal_homeroom_teacher').val(i.id);

            var data_parsley_id = $('#form_modal_homeroom_teacher').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#form_modal_homeroom_teacher').val('');
        }
    });

    // Update record
    $('#tb-classroom_detail').on('click','#btn_edit',function(){
        var id = $(this).data('id');
        var url = $(this).data('url');
        var classroom = $(this).data('classroom');
        // var url = $('#form_edit').attr('action');
        
        const form_id = $('#form_modal_classroom_detail');
        $(form_id).attr('action', url);

        reset_modal_classroom_detail('Form Edit Classroom Detail');

        // AJAX request
        $.ajax({
            url: url,
            type: 'get',
            data: {id: id},
            dataType: 'json',
            success: function(response){

                if(response.data.success == true)
                {
                    $('#form_modal_school_year').val(response.data.classroom_detail.school_year_id);
                    $('#form_modal_school_year-select').val(response.data.classroom_detail.school_year);
                    $('#form_modal_homeroom_teacher').val(response.data.classroom_detail.homeroom_teacher_id);
                    $('#form_modal_homeroom_teacher-select').val(response.data.classroom_detail.homeroom_teacher_name_nip);
                    $('#form_modal_head_class').val(response.data.classroom_detail.head_class_id);
                    $('#form_modal_head_class-select').val(response.data.classroom_detail.head_class_name_nis);
                    $('#form_modal_homeroom_teacher-select').val(response.data.classroom_detail.homeroom_teacher_name_nip);
                    $('#form_modal_is_active').val(response.data.classroom_detail.is_active);
                    $('#form_modal_head_class-select').val(response.data.classroom_detail.head_class_name_nis);
                }
                else
                {
                    $('#form_message').html(response.data.view_messages);
                }
            }
        });
    });

    // Save user 
    $('#btn_save').on('click', function(e) {

        e.preventDefault();
        
        const form_id = $('#form_modal_classroom_detail');
        const url = $(form_id).attr('action');
      
        $.ajax({
            url: url,
            type: 'post',
            data: form_id.serialize(),
            dataType: 'json',
            beforeSend: function(){
                $("#btn_save").attr('disabled', true);
                $("#btn_save").append('Loading...');
                $("#btn_save > span").removeClass("d-none d-sm-block");
                $("#btn_save > span").addClass("spinner-border spinner-border-sm");
                $("#btn_save > span").attr("role", "status");
                $("#btn_save > span").attr("aria-hidden", "true");
                $("#btn_save > span").text("");
            },
            success: function(response){
                
                if(response.data.success == true)
                {
                    // Reload DataTable
                    table.ajax.reload();
                    $('#inlineForm').modal('toggle');
                    $('#form_classroom_message').html(response.data.view_messages);
    
                }
                else
                {
                    $('#form_message').html(response.data.view_messages);
                }
            },
            complete:function(data){
                
                $('#btn_save').removeAttr("disabled");
                
                $('#btn_save').contents().filter(function(){
                    return this.nodeType === 3;
                }).remove();
                $("#btn_save > span").removeClass("spinner-border spinner-border-sm");
                $("#btn_save > span").addClass("d-none d-sm-block");
                $("#btn_save > span").removeAttr("role");
                $("#btn_save > span").removeAttr("aria-hidden");
                $("#btn_save > span").text("Save");

            }
        });
    });

    
    // Delete record
    $('#tb-classroom_detail').on('click','#btn_delete',function(){

        var url = $(this).data('url');
        var id = $(this).data('id');

        $("#btn_confirm_delete").data('url', url);
        $("#btn_confirm_delete").data('id', id);
        $("#warning").modal("toggle");
        $("#warning").modal("show");
    });

    // Delete record
    $('#warning').on('click','#btn_confirm_delete',function(){
        
        var url = $('#btn_confirm_delete').data('url');
        var id = $('#btn_confirm_delete').data('id');
       
        $.ajax({
            url: url,
            type: 'post',
            data: {id: id},
            dataType: 'json',
            beforeSend: function(){
                $("#btn_confirm_delete").attr('disabled', true);
                $("#btn_confirm_delete").append('Loading...');
                $("#btn_confirm_delete > span").removeClass("d-none d-sm-block");
                $("#btn_confirm_delete > span").addClass("spinner-border spinner-border-sm");
                $("#btn_confirm_delete > span").attr("role", "status");
                $("#btn_confirm_delete > span").attr("aria-hidden", "true");
                $("#btn_confirm_delete > span").text("");
            },
            success: function(response){
                
                if(response.data.success == true)
                {
                    // Reload DataTable
                    table.ajax.reload();
                    $('#warning').modal('toggle');
                    $('#form_classroom_message').html(response.data.view_messages);
    
                }
                else
                {
                    $('#form_message').html(response.data.view_messages);
                }
            },
            complete:function(data){
                
                $('#btn_confirm_delete').removeAttr("disabled");
                
                $('#btn_confirm_delete').contents().filter(function(){
                    return this.nodeType === 3;
                }).remove();

                $("#btn_confirm_delete > span").removeClass("spinner-border spinner-border-sm");
                $("#btn_confirm_delete > span").addClass("d-none d-sm-block");
                $("#btn_confirm_delete > span").removeAttr("role");
                $("#btn_confirm_delete > span").removeAttr("aria-hidden");
                $("#btn_confirm_delete > span").text("Yes");

            }
        });
    });

    reset_modal_classroom_detail = function reset_modal_classroom_detail(form_title)
    {
         // save_method = 'add';
         $('#form_modal_classroom_detail')[0].reset(); // reset form on modals
         // $('.form-group').removeClass('has-error'); // clear error class
         // $('.help-block').empty(); // clear error string
         $('#form_message').empty();
         $('#inlineForm').modal('show'); // show bootstrap modal
         $('.modal-title').text(form_title); // Set Title to Bootstrap modal title
 
         // set classroom
         const form_modal_classroom = $('#form_modal_classroom').attr('data-form');
         const form_modal_classroom_id = $('#form_modal_classroom').val();
         
         if(form_modal_classroom_id != '' && form_modal_classroom != '')
         {
             $('#form_modal_classroom-select').autoComplete('set', { value: form_modal_classroom_id, id: form_modal_classroom_id, text: form_modal_classroom });
         }
         
    }
});
