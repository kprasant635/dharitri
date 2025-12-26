<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('list_of_plots_of_land_proposed_for_reclassification'); ?> </h2>
                </div>
                <div class="error_container">
                    <?php
                        if($this->session->flashdata('message')){
                    ?>
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('message'); ?>
                            </strong>
                        </div>
                    <?php
                        }
                    ?>

                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('land_reclassification'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2><mark><?php echo $this->lang->line('present_dag_details'); ?></mark></h2>
                        <hr>
                        <form class='form-horizontal' method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $Pcases->dag_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->patta_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['patta_type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['old_land_class']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_revenue, 2); ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_localtax, 2); ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('total_revenue'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_total_revenue, 2); ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('year_in_which_the_land_is_used_for_other_purpose'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->new_landuse_year; ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group alert alert-success">
                                <label for="inputEmail3" class="col-sm-4 control-label"><span class="ass-btn" style="line-height: 50px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?><?php echo $this->lang->line('land_area'); ?></span></label>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_b; ?>" readonly>
                                </div>

                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_k; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_lc, 2); ?>" readonly>
                                </div>
                                <?php
                                    $dist_code = $this->session->userdata('dist_code');
                                    if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('ganda');?></p>
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_g, 2); ?>" readonly>
                                </div>
                                <!--END PLB//-->
                               
                                 <?php }?>
                                <!--
                                <div class="col-sm-2">
                                    <p class="center bold"><?php //echo $this->lang->line('krantik');  ?></p>
                                    <input type="text" class="form-control" value="<?php //echo $Pcases->dag_area_kr;   ?>" readonly>
                                </div>-->
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('proposed_details'); ?></mark></h2>
                        <hr>
                        <form class='form-horizontal' method="post" action="<?php echo base_url(); ?>index.php/LandReclassification/SaveCoProcessRee" enctype='multipart/form-data' id="myForm">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('new_land_class'); ?></label>
                                <div class="col-sm-4">
                                    <select name="new_land_class" id="new_land_class" class="form-control" required>
                                        <option value="<?php echo $det['pp_code']; ?>" selected><?php echo $det['proposed_land_class']; ?></option>
                                        <?php foreach ($land_class as $lnd_cls): ?>
                                            <option value="<?php echo $lnd_cls->class_code; ?>"><?php echo $lnd_cls->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="P_land_rev" id="P_land" class="form-control" value="<?php echo round($Pcases->proposed_land_revenue, 2); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="p_local_tax" id="p_loc_tax" class="form-control" value="<?php echo round($Pcases->proposed_land_localtax, 2); ?>" readonly>
                                </div>                                
                            </div>
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('revenue_difference'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->revenue_diff, 2); ?>" readonly>
                                </div>
                            </div>
                            <span class='hide'>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark>Additional Deputy Commissioner(s) Recommendation Note</mark></h2>
                            <div class="bs-callout bs-callout-info hide" id="callout-type-b-i-elems"> 
                                <p class='normal'><?php echo $Pcases->adc_report; ?></p>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark>Circlr Officer Previous Note</mark></h2>
                            <div class="bs-callout bs-callout-info hide" id="callout-type-b-i-elems"> 
                                <?php echo $Pcases->co_recommendation; ?>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group hide">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5" disabled> <?php echo $Pcases->co_recommendation; ?></textarea>
                                </div>
                            </div>
                            </span>
                            <!-- <a class="btn btn-info uni_text proreport" id='skmodal' href="<?php echo base_url() . "index.php/LandReclassification/proceedingDetails?proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" >
                                        <i class="fa fa-paperclip"></i>&nbsp;Click here to Show Proceeding
                            </a> -->

                             <a class="btn btn-info uni_text proreport" id='myModal' href="<?php echo base_url() . "index.php/LandReclassification/proceedingDetails?proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" >
                                        <i class="fa fa-paperclip"></i>&nbsp;Click here to Show Proceeding
                            </a>
                            <h2><mark><?php echo $this->lang->line('circleofficers_recommendation_note');?></mark></h2>
                            <hr>
                            <?php
                            include(APPPATH."views/common/addMoreDocumentView.php");

                            if(isset($basundharaAttachment) && $basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                                
                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5">  সার্কেল অফিসারের রিপোর্ট জমা পড়েছে জমি পুনর্বিন্যাসের জন্য ।</textarea>
                                    <!-- <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['co_name'].", ";?><?php echo "চক্র বিষয়া, ".$location['cir']; ?></textarea> -->
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                </div>
                            </div>
                            <?php }
                            else{?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5">  প্রতিবেদন মৰ্মে মাটিৰ  শ্ৰেণী পৰিবৰ্ত্তনৰ  বাবে  হুকুম দিয়া হল ।</textarea>
                                    <!-- <textarea name="co_report_suffix" class="form-control hidden" rows="5"><?php echo $location['co_name'].", ";?><?php echo "চক্র বিষয়া, ".$location['cir']; ?></textarea> -->
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                </div>
                            </div>
                        <?php }?>
                            <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                            <div class="bg bg-primary col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <center class='text-white text-bold'>View Supportive Document</center>
                                <table class="table table-striped table-bordered">
                                    <tbody class="text-dark">
                                        <?php foreach($sup_doc as $doc) { ?>
                                        <tr>
                                            <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                            <td>
                            <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?> 
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12" id="dc_block">
                                    <label class="rasid col-sm-12">
                                        Note : Please Select the Forwarding Officer (Assistant Deputy Commissioner) 
                                    </label>
                                    <center>
                                        <label class="rasid btn">Please Select ADC &nbsp;&nbsp;</label>
                                        <label class="btn btn-success">
                                            <select class="form-control" name='adc_code' id="adc_code" required>
                                                <?php
                                                echo"<option disabled selected> -- Select --</option>";
                                                foreach ($adc as $dcadc) {
                                                    $user_desig_code = $dcadc->user_desig_code;
                                                    $username = $dcadc->username . " ( " . $user_desig_code . " )";
                                                    $user_code = $dcadc->user_code;
                                                    echo"<option value='$user_code'>$username</option>";
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </center>
                                    <br>
                                </div>
                            <div class="form-group">

                                <div class="col-lg-10 col-lg-offset-1">
                                    <center>
                                    <!-- <a href="<?php echo base_url() . "index.php/LandReclassification/revertToLm?proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" class="btn btn-success">
                                        <i class="fa fa-times"></i>&nbsp; Revert back to LM
                                </a> -->

                                

                                <?php if(ESCALATION_ENABLE == 1 && $Pcases->es_flag == 1){ ?>
                                    <a href="<?php echo base_url() . "index.php/LandReclassification/revertToLMReclassByCOEscalation?proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" class="btn btn-success">
                                            <i class="fa fa-times"></i>&nbsp; Revert back to LM
                                    </a>
                                <?php }else{ ?>
                                    <button class="btn revertToLmModal btn-success"><i class='fa fa-arrows-alt'></i> Revert back to LM</button>&nbsp;
                                <?php }  ?>

                                    <button type="submit" class="btn btn-success" onclick="return beforeSubmit(event);"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button></center>
                                    <hr>
                                    <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=" . $Pcases->proposal_no; ?>" class="btn btn-info btn-xs" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_chitha'); ?>
                                    </a>
                                    
                                    <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=" . $Pcases->proposal_no; ?>" target="_blank" class="btn btn-xs btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi'); ?>
                                    </a>
                                    
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-xs btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <input type="hidden" class="form-control" name='application_no' value="<?=isset($app->basundhara)==null?'':$app->basundhara?>">
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal bs-example-modal-lg" tabindex="-1"  id='skmodal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <button type="button" class="close red" data-dismiss="modal">&times;</button>
            <div class="modal-content"  style=" overflow-y: auto;">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Click here to Close</button>
            </div>
        </div>
</div>

<div id="revertToLmModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Revert to LM reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/LandReclassification/revertToLm" method="post">
            <div class="modal-body">
                <?php
                    if($this->session->flashdata('revrt_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('revrt_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
              <!-- <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>"> -->
              <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>">
              <!-- <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>"> -->
                <textarea name='co_report' class="form-control" placeholder="Reason for revert"></textarea>
                <!-- <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['co_name'].", ";?><?php echo "চক্র বিষয়া, ".$location['cir']; ?></textarea> -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form> 
        </div>
    </div>
</div>

 <script>
     $(function () {
        $('.proreport').on('click',function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
            
        });
        $('#skmodal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
        })

        <?php
            if($this->session->flashdata('revrt_mdl_message')){
        ?>
            $('#revertToLmModal').modal('show');
        <?php
            }
        ?>

    });
</script>  

<script type="text/javascript">
    
function beforeSubmit(event) {
        // Prevent the form from submitting
        event.preventDefault();
        var dc_adc= $("#adc_code");

       // alert(dc_adc.val().length);return;

        if(dc_adc.val() === null || dc_adc.val() === undefined || dc_adc.val() === '')
         {
           alert("Please Select ADC");
           return; 
         }

         document.getElementById("myForm").submit();
    }


</script>


