var post_id, nonce, control, post_id2, nonce2, control2 = '';
jQuery(document).ready(function ($) {
    'use strict';
    var in_post_selector = $(".post-box-meta");
    var posts_container = $('.sv-posts-container');
    //Add post to the list
    in_post_selector.on('click', '.sv-control-btn.sv-save-post', function () {
        //e.preventDefault();
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
                //console.log(response.data.added_post);
                $('.sv-save-post').fadeOut(100, function () {
                    $(this).remove();
                });
                in_post_selector.append(response.data.button);
                //posts_container.append(response.data.added_post);
                //todo change the add button to delete
                //todo may be we send the delete button in the response
                //response2.data.added_post
                posts_container.prepend(response.data.added_post);
            }
        });
    });
    //Delete mechanism from the post button
    in_post_selector.on('click', '.sv-delete-btn.sv-control-btn', function () {
        //console.log('done');
        //e.preventDefault();
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

                $('.sv-delete-btn').fadeOut(100, function () {
                    $(this).remove();
                });
                in_post_selector.append(response2.data.button);
                $('.sv-post-container.sv-post-' + response2.data.post_id).fadeOut(300, function () {
                    $(this).remove();
                });

            }
        });
    });

    //Delete mechanism from the floating menu
    posts_container.on('click','.sv-post-container .sv-post-control button',function () {
        // e.preventDefault();
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
                //console.log(response);
                //remove the post
                $('.sv-post-container.sv-post-' + response.data.post_id).fadeOut(300, function () {
                    $(this).remove();
                });
                (function () {
                    //convert post delete to add
                    var current_post_id = $('.post-box-meta .sv-delete-btn');
                    if(current_post_id.data('post-id') == post_id){
                        current_post_id.remove();
                    }
                })();
                //console.log();
                in_post_selector.append(response.data.button);

            }
        });
    });



});