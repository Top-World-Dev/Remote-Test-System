$(document).ready(function() {
    console.log(number);
    if(number > 10) {
        var position = 21 * (number/5);
        $("#btn-group").scrollTop(position);
    }
});