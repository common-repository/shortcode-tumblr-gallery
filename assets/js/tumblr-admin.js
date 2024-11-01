(function ($) {
    "use strict";
    $(function () {
        $('body').on('click','.tumblr-delete',function(){
            if (confirm('Delete this gallery?')) {
                var tumblr_id = $(this).attr('data-value');
                window.location.href='admin.php?page=tumblr_gallery&task=remove_tumblr_gallery&id='+tumblr_id+'';
            }
        })
        $('body').on('click','.tumblr-send',function(){
            var tb_subject = $('.tumblr-subject').val(),
                tb_name = $('.tumblr-name').val(),
                tb_email = $('.tumblr-email').val(),
                tb_message = $('.tumblr-message').val();

            $.ajax({
                url: tumblr_ajax.url,
                type: 'POST',
                data: ({
                    action: 'tumblr_ajax_sendmail',
                    tb_subject: tb_subject,
                    tb_name: tb_name,
                    tb_email: tb_email,
                    tb_message: tb_message
                }),
                success: function(data){
                    if (data){
                        $('.tumblr_suggest').append(data);
                    }
                }
            });
        })
    })
}(jQuery));