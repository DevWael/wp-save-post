var post_id, nonce = '';
jQuery(document).ready(function ($) {
    'use strict';

    $(".sv-save-post").click(function (e) {
        e.preventDefault();
        post_id = $(this).data("post-id");
        nonce = $(this).data("nonce");
        $.ajax({
            type: "post",
            dataType: "json",
            url: sv_ajax_object.sv_ajax_url,
            data: {
                action: "sv_post_id",
                post_id: post_id,
                nonce: nonce
            },
            success: function (response) {
                // console.log('good');
                console.log(response);
                if (response.type == "success") {
                    $("#vote_counter").html(response.vote_count);
                }
                else {
                    // console.log(response);
                }
            }
        });

    });
});