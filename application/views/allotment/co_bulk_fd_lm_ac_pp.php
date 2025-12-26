<style>
    #button{
        display:block;
        margin:20px auto;
        padding:10px 30px;
        background-color:#eee;
        border:solid #ccc 1px;
        cursor: pointer;
    }
    #overlay{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .is-hide{
        display:none;
    }
</style>
<div class="container-fluid form-top login">
    <div class='row'>
        <div class="col-lg-12">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center;">
                    AC TO PP ( 1ST PROCEEDING BULK FORWARD TO LM)
                </h2>
            </div>
        </div>
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>
        <div class='col-lg-12 panel panel-info pt-2 pb-2' style="margin: 0 auto;float: none;">

            <div class="panel-heading ">
                <h3 class="panel-title">
                    <?php echo $this->lang->line('pending_cases'); ?>
                </h3>
            </div>
            <div class="text-danger p-2 bold" style="font-size: 18px;" id="error_a_message">
            </div>
            <form id="co_bulk_fd_ac_to_pp" method="post">
            <table id="co_bulk_ac_pp" class="table table-hover" >
                <thead >
                <tr >
                    <th class="alert-new" style="text-align: center;">
                        <input type="checkbox" id="all_ac_pp" name="all" value="all">
                        All
                    </th>
                    <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                    <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                    <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($cases as $key=>$case): ?>
                    <tr>
                        <td class="alert-new" style="text-align: center;">
                            <input type="checkbox" id="<?= ++$key ?>" class="check_box_ap_pp"
                                   name="case_ac_pp[]" value="<?= $case->case_no ?>">
                        </td>
                        <td><?php echo $case->case_no; ?>
                            <br><span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                        </td>
                        <td>Allotment to PP</td>
                        <td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->date_entry)) ; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
             <!---#START PLB--->
            <?php
            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
              <div class="row pt-2">
                <label class="col-sm-10 uni_text">বরাদ্দকৃত জমির পাট্টা চাওয়া আবেদনকারীর আবেদন যাচাই-বাছাই করা হয়েছে। ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক এটি চরজাহমিনের পরিমাপের উপর একটি বিস্তারিত প্রতিবেদন জমা দেবে |
                    প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ</label>
            </div>
            <?php }else{?>  
            <div class="row pt-2">
                <label class="col-sm-10 uni_text">আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  |
                    প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ</label>
            </div>

        <?php }?>
            <div class="row pt-2">
                <div class="form-group">

                    <div class="col-sm-2 pl-0">
                        <input type="text" class="form-control" id="next_date"  autocomplete="off"
                               placeholder="Select Date" name="next_date" required>
                    </div>
                    <label class="col-sm-8 uni_text">ধাৰ্য্য কৰা হল |</label>
                </div>
            </div>
                <label class="radio-inline uni-text">
                    <input type="radio" name="order_pass"  value="P" checked=""> প্রক্রিয়া জাৰি ৰাখক
                </label>
            <center>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                </a>
            </center>
            </form>
        </div>
    </div>
</div>

<script>
    $('#co_bulk_fd_ac_to_pp').submit(function (e) {
        /////////////////SUBMIT CO FD AC TO PP////////////
        e.preventDefault();
        if(!confirm("Are you sure you want to forward this cases?"))
        {
            return false;
        }
        $("#overlay").fadeIn(300);
        $.ajax({
            url: baseurl + "Allotment/coBulkFDACtoPP",
            type: 'POST',
            data: $("#co_bulk_fd_ac_to_pp").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#overlay").fadeOut(300);
                //console.log(data);
                $('#error_a_message').html('');
                if(data.error)
                {
                    var error_message = '';
                    var error_message2 = '';
                    $.each(data.error, function (index, value) {
                        error_message += '<li>'+value['message']+'</li>';
                        error_message2 += ++index+ '. ' +value['message']+'\n'
                    });
                    $('#error_a_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">' +error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');

                    alert(error_message2);
                    return false;
                }
                if(data.db_error === true)
                {
                    $('#error_a_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">' +data.msg +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    alert('Case Updation Failed...!')
                    return false;
                }

                if(data.db_error === false)
                {
                    alert(data.msg);
                    window.location.reload();
                }

            }

        })

    })

    /////////////////////// Case selection limit////////////////////////
    var limit = <?php echo CO_BULK_SELECT_LIMIT;?>;
    $('.check_box_ap_pp').prop('checked', false);

    $('#all_ac_pp').prop('checked', false);

    $("#all_ac_pp").click(function(){
        if($(this).is(":checked"))
        {
            $('.check_box_ap_pp').prop('checked', true).length >= limit;
        }
        else
        {
            $('.check_box_ap_pp').prop('checked', false);
        }
    });

    $('.check_box_ap_pp').on('change', function (e) {
        if ($('.check_box_ap_pp:checked').length > limit) {
            $(this).prop('checked', false);
            alert("Allowed only "+limit+" cases at a time.");
        }
    });

    $(document).ready(function() {
        $('#co_bulk_ac_pp').DataTable({
            "lengthMenu": [limit,100],
        });

    });

    $('#next_date').datepick({
        minDate: 0, showTrigger: '#calImg'});
</script>
