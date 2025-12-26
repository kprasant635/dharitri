<?php
    // CSRF related setup and global button disable/enable related work are here
  $csrf__enabled = config_item('csrf_protection') == TRUE ? 1 : 0;

?>
<style>
    .swal2-iframe-custom{
        width: 1000px;
        height: 900px;
    }
</style>
<script>
    const CSRF_ENABLED = <?= $csrf__enabled ?>;
    const GET_REFRESH_CSRF_ROUTE = "<?= base_url('index.php/refresh'); ?>";
    var XHR_AJAX_METHOD;
    var XHR_AJAX_URL;
    var clickedBtnEl = '';
    getCsrf();

    $( document ).on( "ajaxSend", function(event, jqxhr, settings) {
        XHR_AJAX_METHOD = settings.type;
        XHR_AJAX_URL = settings.url;
        // disableSubmitBtn();
    });

    $(document).on('submit', 'form', function(e){
        // disableSubmitBtn();
    });

    $(document).on('click', 'button', function(){
        clickedBtnEl = $(this);
    });
    
    $(document).on('click', function (event) {
        if (!$(event.target).closest('button').length) {
            // ... clicked on the 'body', but not on button
            clickedBtnEl = '';
        }

    });


    function getCsrf(){
        let metaEl = $('meta[data-id="csrf-key"]');
        const csrf_key = metaEl.attr('name');
        const csrf_token = metaEl.attr('content');
        config_csrf(csrf_key, csrf_token);
    }

    function setCsrf(){
        if(CSRF_ENABLED == 1){
            // GET_REFRESH_CSRF_ROUTE = "<?= base_url('index.php/refresh'); ?>";
            $('.csrf__token').remove();
            $.ajax({
                    type: "GET",
                    async: false, 
                    url: GET_REFRESH_CSRF_ROUTE, 
                    data: {},
                    dataType: "json",
                    cache:false,
                    success: function(result){
                        const csrf_key = result.csrf_key;
                        const csrf_token = result.csrf_token;
                        let metaEl = $('meta[data-id="csrf-key"]');
                        metaEl.attr('name', csrf_key);
                        metaEl.attr('content', csrf_token);
                        config_csrf(csrf_key, csrf_token);
                    }
                });
        }
    }

    function config_csrf(csrf_key, csrf_token){
        XHR_AJAX = $.ajaxSetup({
            headers : {       
                [csrf_key] : csrf_token
            },
            complete  : function(event, request, settings){
                console.log(XHR_AJAX_URL)
                var sanitize_url = XHR_AJAX_URL.split('?');
                    sanitize_url = sanitize_url[0];
                // console.log(GET_REFRESH_CSRF_ROUTE)
                // if(XHR_AJAX_URL != GET_REFRESH_CSRF_ROUTE){
                if(sanitize_url != GET_REFRESH_CSRF_ROUTE){
                    setCsrf();
                }
                // if(XHR_AJAX_METHOD == 'POST'){
                //     console.log(123);
                //     setCsrf();
                // }
                
                // enableSubmitBtn();
            }
        });
        $("form").each(function() {
            $(this).append(`<input class="csrf__token" name="${csrf_key}" type="hidden" value="${csrf_token}" >`);
        }); 

    }

    function disableSubmitBtn(){
        $('input[type="submit"]').addClass('form__submit_input_btn');
        $('input[type="submit"]').each(() => {
            if(!$(this).is(':disabled')){
                console.log($('input[type="submit"]').length);
                $(this).addClass('form__submit_input_btn');
            }
        });

        if(clickedBtnEl != ''){
            $(clickedBtnEl).addClass('form__submit_btn');
        }else{
            $('button').each(() => {
                if(!$(this).is(':disabled')){
                    $(this).addClass('form__submit_btn');
                }
            });
        }

        $('.form__submit_btn, .form__submit_input_btn').attr('disabled', true);
    }

    function enableSubmitBtn(){
        $('.form__submit_btn, .form__submit_input_btn').prop('disabled', false);
        $('.form__submit_btn, .form__submit_input_btn').removeClass('form__submit_btn');
    }

    $(document).ready(function(){
        const actionUrl = "<?= base_url('index.php/get-file'); ?>";
        $('.preview__file').each(function(){
            const $this = $(this);
            $this.attr('href', `${actionUrl}?file__path=${$this.data('path')}`);
            $this.attr('target', '_blank');
        });

    });

    // Get File and Preview
    // $(document).on('click', '.preview__file', function(e){
    //     e.stopPropagation();
    //     const filePath = $(this).data('path');
    //     const actionUrl = "<?= base_url('index.php/get-file'); ?>";

    //     $.ajax({
    //         url : actionUrl,
    //         data: {
    //             file__path: filePath
    //         },
    //         success: function(response){

    //             Swal.fire({
    //                 title: "Uploaded File",
    //                 customClass: 'swal2-iframe-custom',
    //                 showConfirmButton: false,
    //                 html: `<iframe src="data:${response.content_type};base64,${response.base64encoded_data}#toolbar=0&navpanes=0&scrollbar=0" height="700" width="800"></iframe>`
    //             });
    //         },
    //         error: function(data){
    //             var errors = data.responseJSON;
    //             Swal.fire({
    //                 title: errors.message,
    //                 icon: 'error'
    //             });
    //         }
    //     });
    // });

</script>