<?php
    ///////////// BARAK VALLEY CODE START HERE ////////////////
    $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
?>

<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modala .modal-body').html(data);
                    $('#modala').modal('show');
                    $('#modala .modal-body').addClass('bodytest');
                }
            });

        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalb .modal-body').html(data);
                    $('#modalb').modal('show');
                    $('#modalb .modal-body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalc .modal-body').html(data);
                    $('#modalc').modal('show');
                    $('#modalc .modal-body').addClass('bodytest');
                }
            });

        });

        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modald .modal-body').html(data);
                    $('#modald').modal('show');
                    $('#modald .modal-body').addClass('bodytest');
                }
            });

        });
        $('#co').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modale .modal-body').html(data);
                    $('#modale').modal('show');
                    $('#modale .modal-body').addClass('bodytest');
                }
            });

        });
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalf .modal-body').html(data);
                    $('#modalf').modal('show');
                    $('#modalf .modal-body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div id="modala" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalb" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalc" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modald" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modale" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalf" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Allotment/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    <?php if($rtps!='RTPS' && $rtps!='MB' ){ ?>
                        <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Allotment/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                            <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                        </a>
                    <?php } ?>
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
                <?php
                    if($this->session->flashdata('message')){
                  ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>

                 <?php if(ESCALATION_ENABLE == 1 && $allotment_cb->es_flag == 1) { ?>
                  <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Allotment/escProcessFinal" ?>" method="POST"  >  
                <?php } else { ?>
                  <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Allotment/savedcorder" ?>" method="POST"  >  
                <?php } ?>

                    <div class='panel-body'>
                        <br>	
                         <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                            <table class="table_border">
                                <tr>
                                    <td class="uni_text">কেস নং : <?php echo $allotment_cb->case_no; ?></td>
                                    <td class="uni_text">রুলিং সিরিয়াল নং : 3</td>
                                    <td class="uni_text">তাং : <?php echo date('d-m-Y', strtotime($allotment_cb->date_entry)); ?></td>
                                </tr>
                            </table>
                        <?php } else { ?>
                        <table class="table_border">
                            <tr>
                                <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no; ?></td>
                                <td class="uni_text">হুকুম  ক্রমিক নং : 3</td>
                                <td class="uni_text">তাং : <?php echo date('d-m-Y', strtotime($allotment_cb->date_entry)); ?></td>
                            </tr>
                        </table>
                    <?php }?>

                        <hr>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                            <div class="col-lg-10">

                                <?php
                                ///////////// BARAK VALLEY CODE START HERE ////////////////
                                if($barak){
                                ?>
                                <div class="col-lg-10">
                                <textarea class="form-control" rows=5 placeholder='Type here' name="dc_comment" required="" value="" > চক্র আধিকারিক ,<?php echo $circlename; ?> বরাদ্দ থেকে ইজারা পাওয়ার মাধ্যমে জমা দেওয়া রাজস্ব চক্র <?php echo $allotment_cb->case_no; ?> নং প্রস্তাবটি দেখা হয়েছে। । শাশা কর্মকর্তা প্রস্তাবটি পরীক্ষা করে একটি প্রতিবেদন জমা দেবেন । </textarea>
                                </div>
                                <?php } else { ?>
                                <textarea class="form-control" rows=5 placeholder='Type here' name="dc_comment" required="" value="" > চক্ৰ বিষয়া ,<?php echo $circlename; ?> ৰাজহ  চক্ৰ ই আবন্টনৰ পৰা পট্টা পোৱাৰ বাৱে দাখিল কৰা <?php echo $allotment_cb->case_no; ?> নং প্রস্তাৱ চোবা হ'ল। শাষা বিষয়াই  প্রস্তাৱটো পৰীক্ষা কৰি প্রতিবেদন দাখিল কৰিব । </textarea>
                                <?php }?>
                            </div>		
                        </div>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-2 required control-label ">Next Date of Hearing </label>
                            <div class="col-lg-10">
                                <input type="text" name="next_date" required readonly="" autocomplete="off"  id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >
                                <input type="text" class='hide' name="case_no" required value='<?php echo $allotment_cb->case_no; ?>'>
                            </div>		
                        </div>


                        <hr>

                        <?php if($flag == true && ESCALATION_ENABLE ==1){ ?>
                            <div class="row justify-content-center" id="allocate_days" style="display: none;">
                                <div class="col-md-6">
                                    <label for="">
                                        <b style="color:red;">Warning  : Assign days to CO for report the Case No. (Maximum <?php echo $day = (int) $remaining_days_DC-1; ?> day)</b>
                                    </label>
                                    <select class="form-select" name="allocate_day" >
                                        <?php for ($i=1; $i < $remaining_days_DC; $i++) {  ?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php  } ?>
                                    </select>

                                </div>
                            </div>
                        <?php } ?>
					

                        <hr>
                        <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                            <label class="radio-inline col-lg-offset-2 uni-text">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title="Reject This Case"  value="D"> মামলা খারিজ করুন 
                            </label>                    
                            <label class="radio-inline uni-text ">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title="Forward to Circle Officer" value="P">  চক্র আধিকারিক আবার রিপোর্ট করুন 
                            </label>
                            <?php if(ESCALATION_ENABLE == 1 && $escalation_flag == 1) { ?>
                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title='Final Order Pass'  value="F" checked=""> Final Order Pass 
                            </label>
                        <?php } else { ?>
                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title='Send to BO'  value="R" checked=""> BO তে প্রেরণ করুন 
                            </label>
                        <?php } ?>


                        <?php } else { ?>
                        <label class="radio-inline col-lg-offset-2 uni-text">
                            <input type="radio" name="next_hearing" onclick="alloted_days_check()" title="Reject This Case"  value="D"> গোচৰ খাৰিজ কৰক 
                        </label>					
                        <label class="radio-inline uni-text ">
                            <input type="radio" name="next_hearing" onclick="alloted_days_check()" title="Forward to Circle Officer" value="P">  চক্র বিষয়া পুন: প্রতিবেদন দিয়ক 
                        </label>

                        <?php if(ESCALATION_ENABLE == 1 && $escalation_flag == 1) { ?>
                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title='Final Order Pass'  value="F" checked=""> Final Order Pass 
                            </label>
                        <?php } else { ?>
                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" onclick="alloted_days_check()" title='Send to BO'  value="R" checked=""> BO লৈ প্রেৰণ কৰক 
                            </label>
                        <?php } ?>

                        
                    <?php }?>

                    </div>
                    <?php
                    if($basundharaAttachment){
                    echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
                    foreach ($basundharaAttachment  as $attachment):
                    ?>
                    <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                    <?php 

                    endforeach; 
                    }
                    echo "</div>";
                    ?>
                    <?php if(isset($allot_cert) and !empty($allot_cert)) { ?>
                    <div class="col-lg-12"><h2 class="red">View <?=ALLOT_CERT?></h2>
                    <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$allot_cert->id?>" class="red" download target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo ALLOT_CERT;?> (Click to see the attachment)</a></h6>
                    </div>  
                    <?php } ?>
                    <div class="panel-footer">

                        <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                        <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>

<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
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

<script>

    function alloted_days_check()
    {
        var check_type = $("input[type='radio'][name='next_hearing']:checked").val();
        if(check_type == 'P'){
            $('#allocate_days').show();
        }
        else{
            $('#allocate_days').hide();
        }
    }

</script>