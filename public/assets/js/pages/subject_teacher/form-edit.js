var reset_modal_classroom_detail;

$(document).ready(function() {
  
    const subject_name = $('#subject').attr('data-form');
    const subject_id = $('#subject').val();
    const url_autocomplete_subject = $('#subject').attr('data-form-autocomplete-url');

    const teacher_name = $('#teacher').attr('data-form');
    const teacher_id = $('#teacher').val();
    const url_autocomplete_teacher = $('#teacher').attr('data-form-autocomplete-url');

    $('#subject-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_subject,
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

    if(subject_id != '' && subject_name != '')
    {
        $('#subject-select').autoComplete('set', { value: subject_id, id: subject_id, text: subject_name });
    }

    $('#subject-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#subject').val(i.id);

            var data_parsley_id = $('#subject').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#subject').val('');
        }
    });

    $('#teacher-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_teacher,
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

    if(teacher_id != '' && teacher_name != '')
    {
        $('#teacher-select').autoComplete('set', { value: teacher_id, id: teacher_id, text: teacher_name });
    }

    $('#teacher-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#teacher').val(i.id);

            var data_parsley_id = $('#teacher').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#teacher').val('');
        }
    });

});
