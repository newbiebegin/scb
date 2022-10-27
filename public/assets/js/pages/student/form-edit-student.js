$(document).ready(function() {
 
    const religion_name = $('#religion').attr('data-form');
    const religion_id = $('#religion').val();
    const url_autocomplete_religion = $('#religion').attr('data-form-autocomplete-url');

    const birthplace_name = $('#birthplace').attr('data-form');
    const birthplace_id = $('#birthplace').val();
    const url_autocomplete_birthplace = $('#birthplace').attr('data-form-autocomplete-url');

    const student_guardian_name = $('#student_guardian').attr('data-form');
    const student_guardian_id = $('#student_guardian').val();
    const url_autocomplete_student_guardian = $('#student_guardian').attr('data-form-autocomplete-url');
 
    $('#religion-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_religion,
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

    if(religion_id != '' && religion_name != '')
    {
        $('#religion-select').autoComplete('set', { value: religion_id, id: religion_id, text: religion_name });
    }

    $('#religion-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#religion').val(i.id);

            var data_parsley_id = $('#religion').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#religion').val('');
        }
    });

    $('#birthplace-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_birthplace,
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

    if(birthplace_id != '' && birthplace_name != '')
    {
        $('#birthplace-select').autoComplete('set', { value: birthplace_id, id: birthplace_id, text: birthplace_name });
    }

    $('#birthplace-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#birthplace').val(i.id);

            var data_parsley_id = $('#birthplace').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#birthplace').val('');
        }
    });

    $('#student_guardian-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_student_guardian,
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
    
    if(student_guardian_id != '' && student_guardian_name !=''){
        $('#student_guardian-select').autoComplete('set', { value: student_guardian_id, id: student_guardian_id, text: student_guardian_name });
    }

    $('#student_guardian-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#student_guardian').val(i.id);

            var data_parsley_id = $('#student_guardian').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#student_guardian').val('');
        }
    });
});
