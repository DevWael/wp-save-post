var post_id, nonce, control, post_id2, nonce2, control2 = '';
jQuery(document).ready(function ($) {
    'use strict';
    //Add post to the list
    $(".sv-control-btn.sv-save-post").click(function (e) {
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
                $('.sv-save-post').fadeOut(100, function () {
                    $(this).remove();
                });
                $('.post-box-meta').append(response.data.button);
                //todo change the add button to delete
                //todo may be we send the delete button in the response
            }
        });
    });

    //Delete mechanism from the post button
    $(".sv-delete-btn.sv-control-btn").click(function (e) {
        e.preventDefault();
        post_id2 = $(this).data("post-id");
        nonce2 = $(this).data("nonce");
        control2 = $(this).data("control");
        $.ajax({
            type: "post",
            dataType: "json",
            url: sv_ajax_object.sv_ajax_url,
            data: {
                action: "sv_post_id",
                post_id: post_id2,
                nonce: nonce2,
                control: control2
            },
            success: function (response2) {
                console.log(response2);
                $('.sv-delete-btn').fadeOut(100, function () {
                    $(this).remove();
                });
                $('.post-box-meta').append(response2.data.button);
                //todo change the add button to delete
                //todo may be we send the delete button in the response
            }
        });
    });

    //Delete mechanism from the floating menu
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
                //remove the post
                $('.sv-post-container.sv-post-' + response.data.post_id).fadeOut(300, function () {
                    $(this).remove();
                });

                // $('.post-box-meta').append(response.data.button);
            }
        });
    });
});