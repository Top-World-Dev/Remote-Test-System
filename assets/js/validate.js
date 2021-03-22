var flag = false;
$(document).ready(function () {
    $('.select1, .select2').click(function () {
        if (!flag) {
            compareanswer(this);
        }
    });

    $('.next').click(function () {
        var nextBtn = $('.switch-buttons .active').next();
        if (nextBtn.prop('tagName') == "BUTTON") {
            nextBtn.trigger('click');
        } else {

        }
        return false;
    });

    $('.switch-buttons button').click(function () {
        switchProblem(this);
    })
    initializeClock('clockdiv', new Date(Date.parse(new Date()) + TIME_ALLOWED));
});

compareanswer = function (el) {
    var selectanswer = $(el).data('value');
    $.ajax({
        type: 'POST',
        dataType: 'text',
        data: {
            selectAnswer: selectanswer,
            problemId: $('#problemId').val()
        },
        url: SITE_URL + 'student/checkanswer',
        success: function (data) {
            var json = JSON.parse(data);
            if (json.status) {
                flag = true;
                //$('.pr-ref').empty();
                $('.form-group span.select1').html($('<i>').addClass('fa fa-times')).addClass('wrong-icon');
                $('span[value="' + selectanswer + '"]').html($('<i>')
                    .addClass('fa fa-check'))
                    .addClass('correct-icon');
                $('.answer-text[data-value="' + selectanswer + '"]').addClass('correct-label');
                $('.answer-text').css({ "color": "#ed0b4c" });
                $('.sr-ref').html(json.solution);
            } else {
                $('span[value="' + selectanswer + '"]').html($('<i>')
                    .addClass('fa fa-times'))
                    .addClass('wrong-icon');
                $('.answer-text[data-value="' + selectanswer + '"]').css({ "color": "#ed0b4c" });
            }
        }
    })
}

switchProblem = function (el) {
    $('.switch-buttons button').removeClass('active');
    $(el).addClass('active');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            param: $(el).data('id')
        },
        url: SITE_URL + 'student/problem',
        success: function (response) {
            if (response.status) {
                flag = false;
                isLoaded = true;
                $('.sr-ref').html("");
                $('.question').html(response.data.question);
                if (response.data.preference) {
                    $('.pr-ref').show();
                    $('.pr-ref .fancybox-div').html(response.data.preference);
                } else
                    $('.pr-ref').hide();
                $('.answer-group').html(response.data.answers);
                $('#problemId').val(response.data.pid);

                $('.select1, .select2').click(function () {
                    if (!flag) {
                        compareanswer(this);
                    }
                });
            }
        }
    });
}
