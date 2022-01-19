jQuery(document).ready(function ($) {
    $("#s-word").on("keyup", function (event) {
        if (event.keyCode == 13) {
            search_in_google();
        }
    });

    $("#b-word").on("click", function (event) {
        search_in_google();
    });

    function search_in_google() {
        keyword = $('#s-word').val();
        category = $('#id_category').val();
        if ($.trim(keyword) == '')
            return;

        $.LoadingOverlay("show");
        admin_ajax_url = $('#admin_url').val();
        action = 'search_in_google';
        $.ajax({
            type: 'POST',
            url: admin_ajax_url,
            data: {
                'action': action,
                'keyword': keyword,
                'category': category,
            },
            success: function (data) {
                $.LoadingOverlay("hide");
                data = JSON.parse(data);
                html = '';
                if (data.length === undefined || data.length == 0) {
                    html = '<ul class="sgs-results">検索結果がありません。</ul>';
                }
                else {
                    html = '<ul class="sgs-results">検索Hit数：' + data.length; + "<br>";
                    $.each(data, function (key, item) {
                        html += ('<li class="sgs-item"><div class="sgs-item-query"><h2 class="sgs-item-title">' + item[1] + '</h2></div>');
                        html += ('<div class="sgs-item-answer">');
                        for (var i = 2; i < item.length; i += 2) {
                            html += ('<div>');
                            if (item[i] !== undefined) {
                                html += ('<p class="item-query-text">' + item[i] + '</p>');
                            }
                            if (item[i + 1] !== undefined) {
                                html += ('<p class="item-answer-text">' + item[i + 1] + '</p>');
                            }
                            html += ('<div>');
                        }
                        html += ('</div></li>');
                    });
                    html += '</ul>';
                }
                $('.search-content').html(html);

            },
            error: function (data) {
                $.LoadingOverlay("hide");
            }
        });
    }

    $(document).on('click', '.sgs-item-query', function () {
        var show = $(this).next('.sgs-item-answer').css("display");
        $(this).next('.sgs-item-answer').slideToggle();
    });

    $(".dlg-show").on("click", function () {
        $(".dlg-mask").addClass("active");
        $('#agree').prop('checked', false);
        $('#submit-btn').prop('disabled', true);
    });


    function closeModal() {
        $(".dlg-mask").removeClass("active");
    }

    $(".dlg-close, .dlg-mask").on("click", function () {
        closeModal();
    });

    funcResize();
    $(window).resize(function () {
        funcResize();
    });

    function funcResize() {
        var wid = $(window).width();

        //画像の切替
        if (wid < 768) {
            $('.switch').each(function () {
                $(this).attr("src", $(this).attr("src").replace('_pc', '_sp'));
            });
        } else {
            $('.switch').each(function () {
                $(this).attr("src", $(this).attr("src").replace('_sp', '_pc'));
            });
        }
        //sp_menu(画像の置換)
        if (wid < 768) {
            $('header nav').each(function () {
                $(this).addClass('sp-nav').removeClass('pc-nav');
            });
        } else {
            $('header nav').each(function () {
                $(this).addClass('pc-nav').removeClass('sp-nav');
            });
        }
    };

    $('.drop-down-parent').hover(function () {
        $('.drop-down').css('display', 'block');
    }, function () {
        $('.drop-down').css('display', 'none');
    });

    $('.bxslider').bxSlider({
        mode: 'fade',
        auto: true,
        autoControls: false,
        pager: false,
        controls: false,
        touchEnabled: true,
    });

    $('.menu-toggle').click(function () {
        $('nav.sp ul.sp-menu').slideToggle();
        $(this).toggleClass('open');
    });

    $(document).on('click', '#agree', function () {
        $('#submit-btn').prop('disabled', !$(this).is(':checked'));
    })

});