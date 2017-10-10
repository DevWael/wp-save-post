var post_id, nonce, control = '';
jQuery(document).ready(function ($) {
    'use strict';
    //Add post to the list
    $(".sv-save-post").click(function (e) {
        e.preventDefault();
        post_id = $(this).data("post-id");
        nonce = $(this).data("nonce");
        control = $(this).data("control");
        $.ajax({
            type: "post",
            dataType: "json",
            url: sv_ajax_object.sv_ajax_url,
            data: {
                action: "sv_post_id",
                post_id: post_id,
                nonce: nonce,
                control: control
            },
            success: function (response) {
                console.log(response);
            }
        });
    });

    //Delete post from the list
    $(".sv-post-container .sv-post-control button").click(function (e) {
        e.preventDefault();
        post_id = $(this).data("post-id");
        nonce = $(this).data("nonce");
        control = $(this).data("control");
        $.ajax({
            type: "post",
            dataType: "json",
            url: sv_ajax_object.sv_ajax_url,
            data: {
                action: "sv_post_id",
                post_id: post_id,
                nonce: nonce,
                control: control
            },
            success: function (response) {
                console.log(response);
                $('.sv-post-container.sv-post-' + response.data.post_id).fadeOut(300);
            }
        });
    });
});