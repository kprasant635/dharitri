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
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION CASES ( 1st PROCEEDING BULK FORWARD TO LM)";
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="text-danger p-2 bold" style="font-size: 20px;" id="error_a_message">
                    </div>
                    <div class="panel-body">
                        <?php
                        if ($process == '1') {
                        ?>
                        <form id="co_bulk_fd_to_lm" method="post">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode'
                                   id='bulkcases' width="100%">
                                <thead>
                                <th style="text-align: center;"><input type="checkbox" id="all" name="all" value="all">
                                    All
                                </th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                </th>
                                <th class="center"><label
                                            class="control-label"><?php echo $this->lang->line('case_type'); ?> /
                                        Location</label></th>
                                <th class="center"><label
                                            class="control-label"><?php echo $this->lang->line('submission_date'); ?></label>
                                </th>

                                </thead>
                                <?php foreach ($cases as $key => $case): ?>
                                    <tr id="<?= $case->case_no ?>">
                                        <td style="text-align: center;">
                                            <input type="checkbox" id="<?= ++$key ?>" class="check_box"
                                                   name="check_case[]" value="<?= $case->case_no ?>">
                                        </td>
                                        <td>
                                            <?php echo $case->case_no; ?>
                                                <br>
                                                <span class='small font-italic red'><?php if ($case->basundhara) {
                                                        echo "Basundhara:" . $case->basundhara;
                                                    } ?> </span>
                                            </td>
                                        <td class="center"><?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
                                            }
                                            echo "<br>Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited
                                            On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <!--                                        <td class="center"><a class="btn btn-success btn-block" href="-->
                                        <?php //echo base_url(); ?><!--index.php/COconversionPartha/FirstProcess?case_no=-->
                                        <?php //echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?><!--">-->
                                        <?php //echo $this->lang->line('write_report'); ?><!--</a></td>-->
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <div class="row pt-2">
                                <div class="form-group">
                                    <div class="col-sm-2 pl-0">
                                        <input type="text" class="form-control" id="popupDatepicker"
                                               placeholder="Select Date" name="hearing_date" required>
                                    </div>
                                    <label class="col-sm-8 uni_text" style=" font-size: 18px;">তাৰিখ শুনানি আৰু আপত্তি
                                        দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
                                </div>
                                <br>
                                <label class="control-label uni_text pull-right"
                                       style="float:right; font-size: 22px; text-align: right"><?php echo $location['add_to']; ?>
                                    <br>চক্র বিষয়া, <?php echo $location['cir']; ?></label>
                            </div>


                            <?php
                            }
                            ?>
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
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
            $('#bulkcases').DataTable({        
                "lengthMenu": [50,100]
            }); 
    });
    $('#co_bulk_fd_to_lm').submit(function (e) {
        e.preventDefault();
     if(!confirm("Are you sure you want to forward this cases?"))
     {
         return false;
     }
        $("#overlay").fadeIn(300);
        $.ajax({
            url: baseurl + "COconversionPartha/coBulkForward",
            type: 'POST',
            data: $("#co_bulk_fd_to_lm").serialize(),
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
    $('.check_box').prop('checked', false);
    $('#all').prop('checked', false);

    $("#all").click(function(){

        if($(this).is(":checked"))
        {
            $('.check_box').prop('checked', true).length >= limit;
        }
        else
        {
            $('.check_box').prop('checked', false);
        }

    });

    $('.check_box').on('change', function (e) {
        if ($('.check_box:checked').length > limit) {
            $(this).prop('checked', false);
            alert("Allowed only "+limit+" cases at a time.");
        }
    });

</script>