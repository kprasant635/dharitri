<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#co').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });
    });
</script>

<div class="container-fluid form-top login">
    <div class="row">

        <?php if($this->session->flashdata('message')):?>
        <div class="col-lg-12 ">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
            </div>
        </div>
        <?php endif; ?>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Allotment/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>

                    <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Allotment/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                    </a>

                    <div class="btn btn-info hide uni_text" ><i class="fa fa-check-square-o "></i> &nbsp; View Chitha</div>
                </div>
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-success uni_text" id='lm' href='<?php echo base_url() . 'index.php/Allotment/viewlmnote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LM Report
                    </a>
                    <a class="btn btn-warning uni_text" id='sk' href='<?php echo base_url() . 'index.php/Allotment/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View SK Report
                    </a>
                    <a class="btn btn-danger uni_text" id='pr' href='<?php echo base_url() . 'index.php/Allotment/viewpro?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Proceeding Report
                    </a>
                    <a class="btn btn-info hide uni_text" id='co' href='<?php echo base_url() . 'index.php/Allotment/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View CO Report
                    </a>  
                </div>
                <h2 class="text-center" style="top:50px; margin-top:20px;z-index:1000"> উপায়ুক্তৰ  হুকুম </h2>

                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Allotment/savedcorder" ?>" method="POST"  >   
                    <div class='panel-body'>
                        <br>	

                        <table class="table_border">
                            <tr>
                                <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no; ?></td>
                                <td class="uni_text">হুকুম  ক্রমিক নং : 3</td>
                                <td class="uni_text">তাং : <?php echo date('d-m-Y', strtotime($allotment_cb->date_entry)); ?></td>
                            </tr>
                        </table>

                        <hr>

                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <label class="text-red">Reason of Reverting By CO</label><br>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="rasid" style="color:red !important"><?=$allotment_cb->co_order?></strong>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;<hr></div>

                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <label>ADC Remark</label><span class="text-red text-bold">*</span>
                            <textarea class="form-control" rows=5 placeholder='Type here' name="dc_comment" required="" value="" > চক্ৰ বিষয়া ,<?php echo $circlename; ?> ৰাজহ  চক্ৰ ই আবন্টনৰ পৰা পট্টা পোৱাৰ বাৱে দাখিল কৰা <?php echo $allotment_cb->case_no; ?> নং প্রস্তাৱ চোবা হ'ল। শাষা বিষয়াই  প্রস্তাৱটো পৰীক্ষা কৰি প্রতিবেদন দাখিল কৰিব । </textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <div class="col-lg-4">
                                <label for="inputEmail" class="required control-label ">Next Date of Hearing </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="next_date" required autocomplete="off"  id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >
                                <input type="text" class='hide' name="case_no" required value='<?php echo $allotment_cb->case_no; ?>'>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <!-- <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" title="Reject This Case"  value="D"> গোচৰ খাৰিজ কৰক 
                            </label>   -->                  
                            <label class="radio-inline uni-text ">
                                <input type="radio" name="next_hearing" title="Forward to Circle Officer" value="P">  চক্র বিষয়া পুন: প্রতিবেদন দিয়ক 
                            </label>
                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" title='Send to BO' value="R" checked=""> BO লৈ প্রেৰণ কৰক 
                            </label>
                        </div>
                        
                        

                    </div>
                    <?php
                    if($basundharaAttachment){
                        echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
                        foreach ($basundharaAttachment  as $attachment):
                        ?>
                            <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                    <?php endforeach; 
                        }
                        echo "</div>";
                    ?>
                    <div class="panel-footer">
                        <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i>&nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                        <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i>&nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                        <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$allotment_cb->case_no?>','<?=SERVICE_ALLOTMENT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

</div>

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>

<script>
    $('#BackHome').click(function () {
        location.href = "<?php echo base_url(); ?>index.php/home";
    });
    var dateToday = new Date();
    $(function () {
        $("#ddmmyy").datepicker({
            numberOfMonths: 3,
            showButtonPanel: true,
            minDate: dateToday
        });
    });
</script>