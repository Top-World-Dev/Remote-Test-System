function addSpinnerEffect(el, isAppend = true) {
    var spinner = $('<div/>').attr('class', 'spinner-border').append($('<div/>').attr('class', 'sr-only').text('Loading...'))
    if (isAppend)
        $(el).append(spinner).attr('disabled', true)
    else
        $(el).html(spinner)
}

function removeSpinnerEffect(el) {
    $(el).attr('disabled', false).find('.spinner-border').remove()
}

function togglePagination(settings) {
    if (settings._iDisplayLength == -1
        || settings._iDisplayLength > settings.fnRecordsDisplay()) {
        jQuery(settings.nTableWrapper).find('.dataTables_paginate').hide();
    } else {
        jQuery(settings.nTableWrapper).find('.dataTables_paginate').show();
    }
}
