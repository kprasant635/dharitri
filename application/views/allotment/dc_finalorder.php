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
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#co').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

    })

</script>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
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
                        <i class="fa fa-check-square-o "></i> &nbsp; View BO Report
                    </a>  
                </div>
               <?php
                    ///////////// BARAK VALLEY CODE START HERE ////////////////
                    if($barak){
                ?>
                    <h2 class="text-center" style="top:50px; margin-top:20px;z-index:1000"> জেলা প্রশাসকের আদেশ </h2>
                <?php } else { ?>
                    <h2 class="text-center" style="top:50px; margin-top:20px;z-index:1000"> উপায়ুক্তৰ  হুকুম </h2>
                <?php } ///////////// BARAK VALLEY CODE ENDS HERE //////////////// ?>
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
                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Allotment/savefinalorder" ?>" method="POST"  >              
                    <div class='panel-body'>
                        <br>	
                        <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                            <table class="table_border">
                                <tr>
                                    <td class="uni_text">কেস নং : <?php echo $allotment_cb->case_no; ?></td>
                                    <td class="uni_text">রুলিং সিরিয়াল নং : 4</td>
                                    <td class="uni_text">তাং : <?php echo date('d-m-Y', strtotime($allotment_cb->date_entry)); ?></td>
                                </tr>
                            </table>
                        <?php } else { ?>
                        <table class="table_border">
                            <tr>
                                <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no; ?></td>
                                <td class="uni_text">হুকুম  ক্রমিক নং : 4</td>
                                <td class="uni_text">তাং : <?php echo date('d-m-Y', strtotime($allotment_cb->date_entry)); ?></td>
                            </tr>
                        </table>
                    <?php }?>
                        <hr>
					<!---	<?=$allotment_d_p->new_dag; ?>
						<?=$allotment_d_p->new_patta;?>		--->				
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                            <?php
                                ///////////// BARAK VALLEY CODE START HERE ////////////////
                                if($barak){
                            ?>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows=5 placeholder='Type here' name="dc_comment" required="" value="" >আবেদনকারীর (নাম / ঠিকনা) অ্যাপ্লিকেশন দেখা হয়েছে । ভূমিলেখ্য সহায়ক  / ভূমিলেখ্য পৰ্যবেক্ষক / শাখা কর্মকর্তার প্রতিবেদন অনুযায়ী  <?=$mouza ?> মৌজার  <?=$vill?> গাওর <?=$old_dag->d?> নং দাগর <?=$allotment_d_p->b ?> বিঘা <?=$allotment_d_p->k ?> কঠা <?=$allotment_d_p->lc ?> চাটক <?=$allotment_d_p->g ?> গন্ডা বরাদ্দকৃত জমির জন্য জেলা প্রশাসক হিসেবে উক্ত জমি জেলা প্রশাসক হিসেবে তৈরি করার জন্য ভূমিলেখ্য সহায়ক / ভূমিলেখ্য পৰ্যবেক্ষক /শাখা কর্মকর্তার রিপোর্ট আবেদনকারীর নামে পাট্টাতন করার নির্দেশ দেওয়া হয়েছে।</textarea>
                                </div>


                            <?php } else { ?>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows=5 placeholder='Type here' name="dc_comment" required="" value="" >আবেদনকাৰীৰ (নাম / ঠিকনা) ৰ আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক / ভূমিলেখ্য পৰ্যবেক্ষক / শাখা বিষয়াৰ প্রতিবেদন মৰ্মে  <?=$mouza ?> মৌজাৰ  <?=$vill?> গাওৰ <?=$old_dag->d?> নং দাগৰ <?=$allotment_d_p->b ?> বিঘা <?=$allotment_d_p->k ?> কঠা <?=$allotment_d_p->lc ?> লেছা আবন্টিত জমী পট্টনৰ বাবে উপায়ুক্ত বিবেচিত হোবাত উল্লেখিত আবেদিত জমী নতুন দাগ আৰু  নতুন খে:ম্যাদী পট্টাত ভূত্ত কৰাৰ বাবে আবেদনকাৰী নামত পট্টনৰ হুকুম দিয়া হল ।</textarea>
                            </div>	
                            <?php }?>	
                        </div>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-2 required control-label ">Final Date of Hearing </label>
                            <div class="col-lg-10">
                                <input type="text" name="next_date" required readonly="" autocomplete="off" id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >
                                <input type="text" class='hide' name="case_no" required value='<?php echo $allotment_cb->case_no; ?>'>
                            </div>		
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

                        <hr>

                        <div class="row justify-content-center" id="allocate_days">
                           
                        </div>

                        <hr>

                        <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                        <?php if(ESCALATION_ENABLE == 1 && $allotment_cb->es_flag ==0){?>
                            <label class="radio-inline uni-text ">
                                <input type="radio" name="next_hearing" title="Send back to BO" value="R"> শাখা কর্মকর্তার কাছে প্রেরণ করুন
                            </label>
                        <?php } ?>
                            <label class="radio-inline uni-text ">
                                <input type="radio" name="next_hearing" title="Send back to CO" onclick="alloted_days_check()" value="P">  চক্র আধিকারিক আবার রিপোর্ট করুন  
                            </label>

                            <label class="radio-inline uni-text">
                                <input type="radio" name="next_hearing" title='Final Order' onclick="alloted_days_check()" value="F" checked=""> চূড়ান্ত রায় দিন
                            </label>
                        <?php } else { ?>

                            
                        <?php if(ESCALATION_ENABLE == 1 && $allotment_cb->es_flag ==0){?>				
                        <label class="radio-inline uni-text ">
                            <input type="radio" name="next_hearing" title="Send back to BO" value="R"> শাখা বিষয়ালৈ লৈ প্রেৰণ কৰক 
                        </label>
                        <?php } ?>
						<label class="radio-inline uni-text ">
                            <input type="radio" name="next_hearing" title="Send back to CO" onclick="alloted_days_check()" value="P">  চক্র বিষয়া পুন: প্রতিবেদন দিয়ক  
                        </label>

                        <label class="radio-inline uni-text">
                            <input type="radio" name="next_hearing" title='Final Order' onclick="alloted_days_check()"  value="F" checked=""> অন্তিম হুকুম দিয়ক 
                        </label>
                    <?php }?>

                    </div>
                    <div class="panel-footer">
                        <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                        <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                        <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$allotment_cb->case_no?>','<?=SERVICE_ALLOTMENT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                    </div>
                </form>

            </div>
        </div>

    </div>

</div>

<div class="modal" id='actoppSecond' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl">
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
    //BO -> R 
    //CO -> P
    function alloted_days_check(){
        var check_type = $("input[type='radio'][name='next_hearing']:checked").val();
        var stat = false;

        var esc_constant = <?php echo ESCALATION_ENABLE;?>;
        var esc_y_n = <?php echo $allotment_cb->es_flag;?>;

        if(check_type == 'R'){
            stat = true;
            var postData = {
                'case_no': "<?php echo $allotment_cb->case_no;?>",
                'revert_user': 'BO'
            };

        }else if(check_type == 'P'){
            stat = true;

            var postData = {
                'case_no': "<?php echo $allotment_cb->case_no;?>",
                'revert_user': 'CO'
            };
        }

        if(stat == true && esc_y_n==1){
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            
            $.ajax({
                url: baseurl+'Allotment/getRemDaysEscalation',
                type: "POST",
                data: postData,
                success: function(data) {
                    arr = JSON.parse(data); 
                    $.unblockUI();
                   
                    var rem = arr.remainingDays - 1;

                    if(check_type == 'P'){
                        var label = '<b style="color:red;">Warning  : Assign days to CO for report the Case No. (Maximum '+rem+' day)</b>';
                    }

                    if(check_type == 'R'){
                        var label = '<b style="color:red;">Warning  : Assign days to BO for report the Case No. (Maximum '+rem+' day)</b>';
                    }

                    var option = '';
                    for (i=1; i < arr.remainingDays; i++) { 
                        option += '<option value="'+i+'">'+i+'</option>';
                    }

                    var div =   '<div class="col-md-6">'+
                                    '<label for="" id="label_id">'+label+'</label>'+
                                    '<select class="form-select" name="allocate_day" required>'+
                                        option+
                                    '</select>'+
                                '</div>';

                    if(arr.flag == true && esc_constant == 1){
                        $('#allocate_days').html(div);
                    }else{
                        $('#allocate_days').html('');
                    }

                }
            });
        }
    }
</script>