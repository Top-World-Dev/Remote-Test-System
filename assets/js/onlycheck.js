$(document).ready(function() {
    $('input[type="checkbox"][name="answer[]"]').click(function() {
        if($(this).prop('checked')) {
            $('input[type="checkbox"][name="answer[]"]').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
});

$(document).ready(function() {
    $('input[type="checkbox"][name="answer1"]').click(function() {
        if($(this).prop('checked')) {
            $('input[type="checkbox"][name="answer1"]').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
});