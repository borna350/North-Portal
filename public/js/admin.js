$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        hiddenName: true,
        selectYears: 100,
        selectMonths: true
    });

    $('.datepicker-weekdays').datepicker({
        format: 'yyyy-mm-dd',
        hiddenName: true,
        selectYears: 100,
        selectMonths: true,
        daysOfWeekDisabled: '0,6'
    });

    $('.monthpicker').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        format: 'M yyyy',
        startView: 'months',
        minViewMode: 'months',
    });

});

function extend(obj, src) {
    for (let key in src) {
        if (src.hasOwnProperty(key)) obj[key] = src[key];
    }
    return obj;
}

function roundTo(n, digits) {
    return (Math.round( n * 100 ) / 100).toFixed(digits);
}

function numberWithCommas(x) {
    x = roundTo(x,2);
    let parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function formatNumber(num) {
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1')
}

$(function () {
    $('.deletejson').click(function ($e) {
        $e.preventDefault();

        if (confirm($confirmText)) {
            const $id = $(this).data('id');
            const $section = $(this).data('section');
            const $url = $(this).data('url');
            const $token = $(this).data('token');
            console.log('deleting and hide row: ' + $section + ' - ' + $id + ' ... ');
            $(".ajax-delete-msg").hide();

            $.ajax({
                url: $url,
                data: {id: $id, _method: 'DELETE', '_token': $token, timeing: new Date()},
                type: 'DELETE',
                dataType: 'JSON',
                cache: false,
                success: function ($ret) {
                    $(".ajax-delete-msg").show(); // .fadeOut(6000);
                    $('.del-' + $section + '-' + $id).html($ret.msg).addClass('text-danger').hide("slow");
                }
            });
        }
    });

/*    $.each($('input,textarea,select').filter('[required]:visible'), function (i, j) {
        const $ele = $(j).parent();
        const $label = $ele.find('label');
        // if label exists
        if ($label) {
            $label.addClass('text-danger');

            // add asterisks
            const $content = $label.html();
            if ($content && $content.indexOf('*') === -1) {
                $label.html($content + '*');
            }
        }
        else {
            $ele.addClass('text-danger');
        }
    });*/
});

