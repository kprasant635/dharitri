<?php
    $show_submit_report_btn = true;
    if($Pcases->status == 'C'){
        $show_submit_report_btn =  false;
    }
?>

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
                     <?php 
                     if($basundharaApp){ 
                                    // print_r($basundharaApp->applicants[0]->name_ass); 
                       echo '<h2 class="red"><mark>Applicant Information</mark></h2>';
                                ?>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="<?=$basundharaApp->applicants[0]->name_ass ;?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Guardian Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->gurdian_name_ass ;?>" readonly>
                                </div>
                                
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Relation</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->guard_rel_desc_as."(".$basundharaApp->applicants[0]->guard_rel_desc.")";?>" readonly>
                                </div>
                                
                                <label for="inputEmail3" class="col-sm-2 control-label">Mobile</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->mobile ;?>" readonly>
                                </div>
                            </div>



                       <!--  <table class="table">
                         <tr class="bg-primary">
                          
                         <td>Name: <?=$basundharaApp->applicants[0]->name_ass ;?></td>
                          <td>Gurdian: <?=$basundharaApp->applicants[0]->gurdian_name_ass ;?></td>
                          <td>Relation: <?=$basundharaApp->applicants[0]->guard_rel_desc_as."(".$sp->guard_rel_desc.")";?></td>
                          <td>Gender: <?=$this->utilityclass->gender($basundharaApp->applicants[0]->gender);?></td>
                          <td>Mobile: <?=$basundharaApp->applicants[0]->mobile ;?></td>
                         </tr>
                      
                      </table> -->
                                
                                <?php 
                                
                                echo "";
                                }
                            ?>
                        </div>

                    <div class="panel-body">
                        <h2><mark><?php echo $this->lang->line('present_dag_details'); ?></mark></h2>
                        <hr>
                        <form class='form-horizontal' method="post" action="">
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
                        <form class='form-horizontal' method="post" action="<?php echo base_url(); ?>index.php/LandReclassification/SaveCoProcessLMRe" enctype='multipart/form-data'>
                            
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <input type="hidden" class="form-control" name='application_no'  id='application_no' value="<?=$app->basundhara?>">
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
                                <div class="col-sm-4" readonly>
                                    <input type="number" name="P_land_rev" id="P_land" class="form-control" value="<?php echo round($Pcases->proposed_land_revenue, 2); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                                <div class="col-sm-4" readonly>
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
							<h2><mark>Circle Officer Previous Note</mark></h2>
                            <div class="bs-callout bs-callout-info hide" id="callout-type-b-i-elems"> 
                                <?php echo $Pcases->co_recommendation; ?>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group hide">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5" readonly> <?php echo $Pcases->co_recommendation; ?></textarea>
                                </div>
                            </div>
							</span>
							<!-- <a class="btn btn-info uni_text proreport" id='skmodal' href="<?php echo base_url() . "index.php/LandReclassification/proceedingDetails?proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" >
                                        <i class="fa fa-paperclip"></i>&nbsp;Click here to Show Proceeding
                            </a> -->
                           <h2><mark>Circle officer remark</mark></h2>
                            <hr>
                            <?php if($cormk->co_order) {?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5" readonly> <?php echo $cormk->co_order; ?></textarea>
                                </div>
                            </div>
                                </div>
                            </div> 
                            <?php } ?>

                            <?php if($lmrmk->co_order) { ?>

                                <h2><mark>LM remark</mark></h2>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5" readonly> <?php echo $lmrmk->co_order; ?></textarea>
                                </div>
                            </div>

                            <hr style="border-bottom: 2px solid #000;">
                        <?php } ?>

                            <h2><mark>LM remark</mark></h2>

                        <?php
                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5"> জমি পুনর্বিন্যাসের জন্য লাট মণ্ডলের রিপোর্ট জমা দেওয়া হয়েছে ।</textarea>
                                    <!-- <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['lm_name'].", ";?><?php echo "লাট মণ্ডল, "; ?></textarea> -->
                                   <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <!-- <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                                </div>
                            </div>
                        <?php }else{?>

                             <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea name="co_report" class="form-control" rows="5"> মাটিৰ পুন শ্ৰেণী পৰিবৰ্ত্তনৰ  বাবে লাট মণ্ডলৰ প্রতিবেদন দাখিল কৰা হ'ল ।</textarea>
                                        <!-- <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['lm_name'].", ";?><?php echo "লাট মণ্ডল, "; ?></textarea> -->
                                       <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                        <!-- <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                                    </div>
                                </div>
                            <?php }
                            include(APPPATH."views/common/addMoreDocumentView.php");
                            ?>

                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <center>
                                        <?php
                                            if($show_submit_report_btn){
                                        ?>
                                            <button type="submit" class="btn btn-success" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                                        <?php
                                            }
                                        ?>
                                    </center>
                                    <hr>
									<a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" class="btn btn-info btn-xs" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_chitha'); ?>
                                    </a>
									
                                    <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" target="_blank" class="btn btn-xs btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi'); ?>
                                    </a>
									
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-xs btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">

                        <form class="hidden_form_prams">
                            <?php 
                                if(!empty($app->basundhara)){ 
                            ?>
                                <input type="hidden" class="form-control" name='application_no'  id='application_no' value="<?=$app->basundhara?>">
                            <?php
                                }
                            ?>
                            <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['lm_name'].", ";?><?php echo "ভূমিলেখ্য সহায়ক, "; ?></textarea>
                            <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                        </form>
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
    });
</script>  


