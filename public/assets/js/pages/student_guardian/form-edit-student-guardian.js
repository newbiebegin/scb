$(document).ready(function() {
 
    const father_religion_name = $('#father_religion').attr('data-form');
    const father_religion_id = $('#father_religion').val();
    const url_autocomplete_father_religion = $('#father_religion').attr('data-form-autocomplete-url');
    
    const father_occupation_name = $('#father_occupation').attr('data-form');
    const father_occupation_id = $('#father_occupation').val();
    const url_autocomplete_father_occupation = $('#father_occupation').attr('data-form-autocomplete-url');

    const mother_religion_name = $('#mother_religion').attr('data-form');
    const mother_religion_id = $('#mother_religion').val();
    const url_autocomplete_mother_religion = $('#mother_religion').attr('data-form-autocomplete-url');
    
    const mother_occupation_name = $('#mother_occupation').attr('data-form');
    const mother_occupation_id = $('#mother_occupation').val();
    const url_autocomplete_mother_occupation = $('#mother_occupation').attr('data-form-autocomplete-url');
    const student_guardian_religion_name = $('#student_guardian_religion').attr('data-form');
    const student_guardian_religion_id = $('#student_guardian_religion').val();
    const url_autocomplete_student_guardian_religion = $('#student_guardian_religion').attr('data-form-autocomplete-url');
    
    const student_guardian_occupation_name = $('#student_guardian_occupation').attr('data-form');
    const student_guardian_occupation_id = $('#student_guardian_occupation').val();
    const url_autocomplete_student_guardian_occupation = $('#student_guardian_occupation').attr('data-form-autocomplete-url');

    $('#father_religion-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_father_religion,
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

    if(father_religion_id != '' && father_religion_name != '')
    {
        $('#father_religion-select').autoComplete('set', { value: father_religion_id, id: father_religion_id, text: father_religion_name });
    }

    $('#father_religion-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#father_religion').val(i.id);

            var data_parsley_id = $('#father_religion').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#father_religion').val('');
        }
    });
 
    $('#father_occupation-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_father_occupation,
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

    if(father_occupation_id != '' && father_occupation_name != '')
    {
        $('#father_occupation-select').autoComplete('set', { value: father_occupation_id, id: father_occupation_id, text: father_occupation_name });
    }

    $('#father_occupation-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#father_occupation').val(i.id);

            var data_parsley_id = $('#father_occupation').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#father_occupation').val('');
        }
    });
 
    $('#mother_religion-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_mother_religion,
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

    if(mother_religion_id != '' && mother_religion_name != '')
    {
        $('#mother_religion-select').autoComplete('set', { value: mother_religion_id, id: mother_religion_id, text: mother_religion_name });
    }

    $('#mother_religion-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#mother_religion').val(i.id);

            var data_parsley_id = $('#mother_religion').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#mother_religion').val('');
        }
    });
 
    $('#mother_occupation-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_mother_occupation,
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

    if(mother_occupation_id != '' && mother_occupation_name != '')
    {
        $('#mother_occupation-select').autoComplete('set', { value: mother_occupation_id, id: mother_occupation_id, text: mother_occupation_name });
    }

    $('#mother_occupation-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#mother_occupation').val(i.id);

            var data_parsley_id = $('#mother_occupation').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#mother_occupation').val('');
        }
    });
 
    $('#student_guardian_religion-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_student_guardian_religion,
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

    if(student_guardian_religion_id != '' && student_guardian_religion_name != '')
    {
        $('#student_guardian_religion-select').autoComplete('set', { value: student_guardian_religion_id, id: student_guardian_religion_id, text: student_guardian_religion_name });
    }

    $('#student_guardian_religion-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#student_guardian_religion').val(i.id);

            var data_parsley_id = $('#student_guardian_religion').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#student_guardian_religion').val('');
        }
    });
 
    $('#student_guardian_occupation-select').autoComplete({
        resolver: 'custom',
        events: {
            search: function (qry, callback) {
                $.ajax(
                    url_autocomplete_student_guardian_occupation,
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

    if(student_guardian_occupation_id != '' && student_guardian_occupation_name != '')
    {
        $('#student_guardian_occupation-select').autoComplete('set', { value: student_guardian_occupation_id, id: student_guardian_occupation_id, text: student_guardian_occupation_name });
    }

    $('#student_guardian_occupation-select').on('autocomplete.select', function (e, i) {
        if(i != undefined)
        {
            $('#student_guardian_occupation').val(i.id);

            var data_parsley_id = $('#student_guardian_occupation').attr('data-parsley-id');
            $('#parsley-id-'+data_parsley_id).remove();
        }
        else
        {
            $('#student_guardian_occupation').val('');
        }
    });

});
