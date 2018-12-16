$(document).ready(function() {

    __debugbar_resize(1);

    if (localStorage.getItem('__debugbar_height') == null) {
        localStorage.setItem('__debugbar_height', $('.__debugbar').height());
    }

    __debugbar_load('memory');
    __debugbar_load('elapsed');
});

$('.__debugbar_tablink').click(function() {

    $('.__debugbar_tablink').removeClass('__debugbar_tablink_active');

    var id = $(this).attr('id');

    if (id == undefined) {
        return;
    }

    $(this).addClass('__debugbar_tablink_active');

    $('.__debugbar_tabcontent').each(function(index, element) {
        if ($('.__debugbar_content > #' + element.id).css('display') == 'block' && element.id == id) {
            $('.__debugbar_content > #' + element.id).toggle();
            if ($('.__debugbar').height() > 34) {
                $('.__debugbar').removeClass('ui-resizable').attr('style', '');
            }
        } else if ($('.__debugbar_content > #' + element.id).css('display') == 'none' && element.id == id) {
            __debugbar_load(element.id);
            if (localStorage.getItem('__debugbar_height') > 34) {
                $(".__debugbar").css('height', localStorage.getItem('__debugbar_height'));
            }

            $('.__debugbar_content > #' + element.id).toggle();
        } else {
            $('.__debugbar_content > #' + element.id).css('display', 'none');
        }
    });
});

function __debugbar_resize__init() {
    if (!$('.__debugbar').resizable('instance')) {
        $('.__debugbar').resizable({
            maxHeight: 450,
            minHeight: 33,
            handles: 'n, s',
            stop: function(event, ui) {
                var height = ui.size.height;
                localStorage.setItem('__debugbar_height', height);
                $('.__debugbar').css('width', '');
                $('.__debugbar_scroll').css('max-height', height - 100);
            }
        });
    }
}

function __debugbar_resize_destroy() {
    if ($('.__debugbar').resizable('instance')) {
        $('.__debugbar').resizable('destroy');
    }
}

function __debugbar_resize(i) {

    if (i == null) {
        localStorage.setItem('__debugbar_height', 34);
    }

    if ($('.__debugbar_hide').length == 1) {
        __debugbar_resize__init();
    } else {
        __debugbar_resize_destroy();
    }

    if (localStorage.getItem('__debugbar_height') > 34 && i == 1) {

        $(".__debugbar").css('height', localStorage.getItem('__debugbar_height'));

        var element = localStorage.getItem('__debugbar_last_call');

        __debugbar_load(element);

        $('.__debugbar_content > #' + element).css('display', 'block');

        $('#' + element).addClass('__debugbar_tablink_active');

        __debugbar_resize__init();

    } else {
        $('.__debugbar').toggleClass('__debugbar_hide').removeClass('ui-resizable').attr('style', '');
        $('.__debugbar_tab, .__debugbar_content').toggle();
    }
}

function __debugbar_load(action) {

    localStorage.setItem('__debugbar_last_call', action);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': __debugbar_token
        },
        url: __debugbar_url.load,
        type: 'POST',
        dataType: 'html',
        data: {
            __debugbar_file: __debugbar_file,
            __debugbar_action: action,
            },
        })
    .done(function(e) {
        if (action == 'memory' || action == 'elapsed') {
            $('.__debugbar_tablink > span#' + action).html(e).removeClass('__debugbar_tablink_active');
        } else {
            $('.__debugbar_content > #' + action).html(e);
            $('.__debugbar_scroll').css('max-height', $('.__debugbar').height() - 100);
            if($('.__debugbar_scroll').length > 0) {
                $('.__debugbar_scroll').niceScroll({
                    cursorborder: "none",
                    cursorwidth : "3px",
                    cursorcolor : __debugbar_cursorcolor
                });
            }
        }
        
        if (action == 'query') {
            $('td.__debugbar_sql').each(function(i, block) {
                octopyfw.highlight(block);
            });
        }
    });
}

function __debugbar_delete(file) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': __debugbar_token
        },
        url: __debugbar_url.delete,
        type: 'POST',
        dataType: 'html',
        data: {
            __debugbar_file: file,
        },
    })
    .done(function(e) {
        __debugbar_load('history');
    });
}


function __debugbar_reload(file) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': __debugbar_token
        },
        url: __debugbar_url.reload,
        type: 'POST',
        dataType: 'html',
        data: {
            __debugbar_request: true,
            __debugbar_file: file,
        },
    })
    .done(function(e) {
        $('.__debugbar_content > #history').toggle();
        __debugbar_load('route');
        $('.__debugbar_tablink').removeClass('__debugbar_tablink_active');
        $('.__debugbar_content > #route').toggle();
        $('#route').addClass('__debugbar_tablink_active');
        __debugbar_load('memory');
        __debugbar_load('elapsed');
    });
}