$(document).ready(function () {
    $.ajax({
        url: '/ajax/comps',
        dataType: 'html',
        success: function (data) {
            document.getElementById('lgu').innerHTML = data;
        }
    });
    var fn = function () {
        $.ajax({
            url: '/ajax/comps',
            dataType: 'html',
            success: function (data) {
                document.getElementById('lgu').innerHTML = data;
            }
        });
        setTimeout(arguments.callee, 50000);
    }


    setTimeout(fn, 50000);


});