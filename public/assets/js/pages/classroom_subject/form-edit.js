var reset_modal_classroom_detail;

$(document).ready(function() {
  
    const classroom = $('#classroom').attr('data-form');
    const classroom_id = $('#classroom').val();
    const url_autocomplete_classroom = $('#classroom').attr('data-form-autocomplete-url');
 
    const school_year = $('#school_year').attr('data-form');
    const school_year_id = $('#school_year').val();
    const url_autocomplete_school_year = $('#school_year').attr('data-form-autocomplete-url');
 
    const subject_teacher_name = $('#subject_teacher').attr('data-form');
    const subject_teacher_id = $('#subject_teacher').val();
    const url_autocomplete_subject_teacher = $('#subject_teacher').attr('data-form-autocomplete-url');

    $('#classroom-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                
                $.ajax(
                    url_autocomplete_classroom,
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

    if(classroom_id != '' && classroom != '')
    {
        $('#classroom-select').autoComplete('set', { value: classroom_id, id: classroom_id, text: classroom });
    }

    $('#classroom-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#classroom').val(i.id);

            var data_parsley_id = $('#classroom').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#classroom').val('');
        }
    });

    $('#school_year-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                
                $.ajax(
                    url_autocomplete_school_year,
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

    if(school_year_id != '' && school_year != '')
    {
        $('#school_year-select').autoComplete('set', { value: school_year_id, id: school_year_id, text: school_year });
    }

    $('#school_year-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#school_year').val(i.id);

            var data_parsley_id = $('#school_year').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#school_year').val('');
        }
    });

    $('#subject_teacher-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                
                $.ajax(
                    url_autocomplete_subject_teacher,
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

    if(subject_teacher_id != '' && subject_teacher_name != '')
    {
        $('#subject_teacher-select').autoComplete('set', { value: subject_teacher_id, id: subject_teacher_id, text: subject_teacher_name });
    }

    $('#subject_teacher-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#subject_teacher').val(i.id);

            var data_parsley_id = $('#subject_teacher').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#subject_teacher').val('');
        }
    });

});
