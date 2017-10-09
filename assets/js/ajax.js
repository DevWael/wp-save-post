var post_id, nonce = '';
jQuery(document).ready(function ($) {
    'use strict';
    //Add post to the list
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
                nonce: nonce,
                //control
                //ToDO add control type to the object
            },
            success: function (response) {
                // console.log('good');
                console.log(response);
                if (response.success == true) {
                    $("#vote_counter").html(response.vote_count);
                }
                else {
                    // console.log(response);
                }
            }
        });

    });

    //Delete post from the list
    $(".sv-post-container .sv-post-control button").click(function (e) {
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
                if (response.success == true) {
                    $("#vote_counter").html(response.vote_count);
                }
                else {
                    // console.log(response);
                }
            }
        });

    });

});