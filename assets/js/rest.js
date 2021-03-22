var progressInterval,
    index = 0,
    flag = false,
    isLast = false,
    isFirst = true,
    isLoaded = false,
    compareanswer = function (el) {
        var answer = $(el).data('value');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                params: [$('#problemId').val(), answer, $('#dropboxId').val(), $('#ptype').val(), $('#mode').val(), elapsed, isFirst]
            },
            url: SITE_URL + 'rest/checkanswer',
            beforeSend: function (request) {
                request.setRequestHeader("X-API-KEY", API_KEY);
                request.setRequestHeader("Authorization", AUTH_TOKEN);
            },
            success: function (response) {
                isFirst = false;
                if (response.status) {
                    flag = true;
                    // $('.pr-ref').empty();
                    $('.form-group span.select1').html($('<i>').addClass('fa fa-times')).addClass('wrong-icon');
                    $('span[value="' + answer + '"]').html($('<i>')
                        .addClass('fa fa-check'))
                        .addClass('correct-icon');
                    $('.answer-text[data-value="' + answer + '"]').addClass('correct-label');
                    $('.answer-text').css({ "color": "#ed0b4c" });
                    $('.sr-ref').html(response.solution);
                    if (isLast) displaySummary(response.summary);
                } else {
                    if ($('#mode').val() != "Practicing") {
                        flag = true;
                        if (isLast) displaySummary(response.summary);
                    }
                    $('span[value="' + answer + '"]').html($('<i>')
                        .addClass('fa fa-times'))
                        .addClass('wrong-icon');
                    $('.answer-text[data-value="' + answer + '"]').css({ "color": "#ed0b4c" });
                }
                $('.next').attr('disabled', false);
            }
        })
    },
    processProgress = function () {
        var progress = $(".progress"),
            progressBack = progress.closest('.progress-back');
        clearInterval(progressInterval);
        progressBack.show();
        var step = 10;
        progress.find('.progress-bar').css('width', '10%');
        progressInterval = setInterval(function () {
            if (step > 100) {
                step = 100;
            } else {
                step += 2;
            }
            progress.find('.progress-bar').css('width', step + '%');
            if (isLoaded) {
                step = 100;
                progress.find('.progress-bar').css('width', step + '%');
                if (step >= 100) {
                    clearInterval(progressInterval);
                    setTimeout(() => {
                        progressBack.hide();
                        progress.find('.progress-bar').css('width', '0%');
                    }, 500);
                }
            }
        }, 20);
    },
    switchMode = function () {
        isLoaded = false;
        processProgress();
        $.ajax({
            type: 'POST',
            dataType: 'text',
            data: {
                params: [$('#mode').val(), $('#dropboxId').val()]
            },
            beforeSend: function (request) {
                request.setRequestHeader("X-API-KEY", API_KEY);
                request.setRequestHeader("Authorization", AUTH_TOKEN);
            },
            url: SITE_URL + 'rest/switchMode',
            success: function (data) {
                index = 0;
                flag = false;
                isLast = false;
                isFirst = true;
                isLoaded = true;
                setTimeout(() => {
                    $('body').html(data);
                    addEventListner();
                    initializeClock('clockdiv', new Date(Date.parse(new Date()) + TIME_ALLOWED));
                }, 200);
            }
        });
    },
    switchProblem = function (params) {
        isLoaded = false;
        processProgress();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                params: params
            },
            beforeSend: function (request) {
                request.setRequestHeader("X-API-KEY", API_KEY);
                request.setRequestHeader("Authorization", AUTH_TOKEN);
            },
            url: SITE_URL + 'rest/problem',
            success: function (response) {
                if (response.status) {
                    flag = false;
                    isFirst = true;
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
    },
    displaySummary = function (data) {
        var totalQuestion = 0;
        if (data.time_spent >= 60) {
            var minutes = Math.floor(data.time_spent / 60);
            var second = data.time_spent % 60;
            time_spent = ''
            if (minutes > 0)
                time_spent += minutes + ' Minutes ';
            time_spent += second + ' Sec'
        } else {
            time_spent = data.time_spent + ' Sec';
        }
        $('.module-title').text(data.module);
        $('.time-allowed').text(data.time_allowed);
        $('.time-spent').text(time_spent);
        if ($('#mode').val() == "Practicing")
            totalQuestion = $('.switch-buttons button').length;
        else
            totalQuestion = $('#plist').val().split(',').length;
        $('.total-questions').text(totalQuestion);
        $('.corrects').text(data.corrects);
        $('#summary_modal').modal('show');
    },
    addEventListner = function () {
        $(".fancybox").fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            width: 500,
            height: 500,
        });

        $('.switch-buttons button').click(function () {
            var params = [];
            params[0] = $(this).data('id');
            params[1] = $('#dropboxId').val();
            $('.switch-buttons button').removeClass('active');
            $(this).addClass('active');
            isLast = false;
            if ($(this).next().prop('tagName') == "BUTTON") {
                $('.next').show();
            } else {
                isLast = true;
                $('.next').hide();
            }
            switchProblem(params);
        })

        $('.select1, .select2').click(function () {
            if (!flag) {
                compareanswer(this);
            }
        });

        $('#mode').click(function () {
            if ($(this).is(':checked')) {
                $(this).val('Examination');
                switchMode();
            } else {
                swal({
                    title: "Warning",
                    text: "Are you sure you want to cancel the exam?",
                    showCancelButton: true,
                    allowOutsideClick: false
                }).then(function (data) {
                    if (data.dismiss) {
                        $('#mode').prop('checked', true);
                    } else {
                        $('#mode').val('Practicing');
                        setTimeout(function () {
                            switchMode();
                        }, 100);
                    }
                });
            }
        });

        $('.next').click(function () {
            if ($('#mode').val() == "Practicing") {
                var nextBtn = $('.switch-buttons .active').next();
                if (nextBtn.prop('tagName') == "BUTTON") {
                    nextBtn.trigger('click');
                }
            } else {
                index++;
                var plist = $('#plist').val().split(',');
                if (index < plist.length) {
                    var params = [];
                    params[0] = plist[index];
                    params[1] = $('#dropboxId').val();
                    switchProblem(params);
                    $(this).attr('disabled', true);
                }
                if (index + 1 == plist.length) {
                    isLast = true;
                    $(this).hide();
                }
            }
            return false;
        });
    }
$(document).ready(function () {
    //displaySummary();
    addEventListner();
    initializeClock('clockdiv', new Date(Date.parse(new Date()) + TIME_ALLOWED));
});
