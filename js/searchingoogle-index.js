jQuery(document).ready(function($) {
    $("#s-word").on("keyup", function(event) {
        if (event.keyCode == 13) {
            search_in_google();
        }
    });

    $("#b-word").on("click", function(event) {
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
                if (data.length == 0) {
                    html = '<ul class="sgs-results">検索結果がありません。</ul>';
                }
                else {
                    html = '<ul class="sgs-results">';
                    $.each(data, function(key, item) 
                    {
                        html += ('<li class="sgs-item"><div class="sgs-item-query"><h2 class="sgs-item-title">' + item[1] + '</h2></div>');
                        html += ('<div class="sgs-item-answer">');
                        for(var i = 2; i< item.length; i += 2) {
                            html += ('<div><p>' + item[i] + '</p><span>' + item[i + 1] + '</span></div>');
                        }
                        html += ('</div></li>');
                    });
                        
                    html += '</ul>';
                }
                $('.search-content').html(html);

            },
            error: function(data) {
                $.LoadingOverlay("hide");
            }
        });
    }

    $(document).on('click', '.sgs-item-query', function()
    {
        var show = $(this).next('.sgs-item-answer').css("display");
		$(this).next('.sgs-item-answer').slideToggle();
    });
	
});