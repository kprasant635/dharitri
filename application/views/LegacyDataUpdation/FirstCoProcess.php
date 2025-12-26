<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 col-lg-offset-1">
            <?php
            $buttonEnabledFlag =1;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                include 'application/views/common/input_hidden_fields_and_func.php';
            }
            ?>
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Land Proposed for Legacy Data Modification / Updations </h2>
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
            

            <form class='form-horizontal' id="f1" method="post" action="<?php echo base_url() . 'index.php/LegacyDataUpdation/SaveCoProcess' ?>" enctype="multipart/form-data">
            <input type="hidden" name="executionDate" value="<?=date('Y-m-d');?>">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Location Details
                        </h3>
                    </div>
                    
                    <div class="panel-body">
                        
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['dist']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['sub']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['cir']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['mouza']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['lot']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['vill']; ?>" readonly>
                                </div>
                            </div>
                     
                    </div>
                </div>
            </div>


       <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>

                            
            <div class="col-lg-5 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Old Legacy Data
                        </h3>
                    </div>
                    <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="dag_no" value="<?php echo $Pcases->dag_no; ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control old_patta_code patta_no_val" name="patta_no" value = "<?php echo $Pcases->patta_no; ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control patta_code_val" data-val="<?= $Pcases->patta_type_code; ?>" value="<?php echo $det['patta_type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="<?php echo $det['old_land_class']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Revenue</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_revenue, 2); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_localtax, 2); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Strike/Unstrike Pattadar</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->suggested_pattadarstrike; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-1 control-label">Area</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_b; ?> বিঘা" readonly>
                                </div>
                                <div class="col-sm-3" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  value="<?php echo $Pcases->dag_area_k; ?> কঠা" readonly>
                                </div>
                               
                                <!---#START PLB--->
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  value="<?php echo round($Pcases->dag_area_lc, 2); ?> ছটাক" readonly>
                                    </div>
                                     <div class="col-sm-3" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  value="<?php echo round($Pcases->dag_area_g, 2); ?> গণ্ডা" readonly>
                                    </div>
                                <?php }
                                else{?>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  value="<?php echo round($Pcases->dag_area_lc, 2); ?> লেছা" readonly>
                                    </div>
                                <?php }?>

                                <!---#END PLB-->

                                 
                            </div>
                            <hr class="border" style="border-bottom: 2px solid #000;">
                            <h2><mark>Lot Mondal's Note</mark></h2>
                            <?php echo $Pcases->lm_note; ?>
                            <hr class="border" style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?php 
                                    if($Pcases->file_upload){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>LDUDocs/<?php echo $Pcases->file_upload; ?>" class="btn btn-info" target="_blank"> -->
                                        <!-- <a href="<?php echo base_url(search_file_location('LDUDocs/' . $Pcases->file_upload)); ?>" class="btn btn-info" target="_blank"> -->
                                        <a href="javascript:void(0);" data-path="<?php echo search_file_location('LDUDocs/' . $Pcases->file_upload); ?>" class="preview__file btn btn-info">
                                            <i class="fa fa-paperclip"></i>&nbsp;Verify Uploaded Documents
                                        </a>
                                        <!-- <a href="<?php echo get_file_location('LDUDocs', $Pcases->file_upload, 'uploads_back_feb224'); ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;Verify Uploaded Documents
                                        </a> -->
                                        <?php
                                    } ?>


                                    <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }

                                    else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>



                                    <a href="<?php echo base_url() . "index.php/LegacyDataUpdation/generateChitha?dist_code=".$details->dist_code . "&subdiv_code=" . $details->subdiv_code . "&cir_code=" . $details->cir_code . "&mouza_pargona_code=" . $details->mouza_pargona_code . "&lot_no=" . $details->lot_no . "&vill_townprt_code=" . $details->vill_townprt_code . "&dag_no=" . $details->dag_no . "&patta_no=" . $details->patta_no . "&patta_type=" .$details->patta_type_code; ?>" class="btn btn-info" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;Verify Chitha
                                    </a>
                                    <a href="<?php echo base_url() . "index.php/LegacyDataUpdation/saveJamabandiByPattano?dist_code=".$details->dist_code . "&subdiv_code=" . $details->subdiv_code . "&cir_code=" . $details->cir_code . "&mouza_pargona_code=" . $details->mouza_pargona_code . "&lot_no=" . $details->lot_no . "&vill_townprt_code=" . $details->vill_townprt_code . "&dag_no=" . $details->dag_no . "&patta_no=" . $details->patta_no . "&patta_type=" .$details->patta_type_code; ?>" target="_blank" class="btn btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;Verify Jamabandi
                                    </a>

                                    <a href="javascript:void(0);" data-bs-target="#historyModal" data-bs-toggle="modal" class="get_history btn btn-warning" data-case_no="<?= $Pcases->case_no; ?>"><i class="fa fa-eye"></i>&nbsp;View History</a>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Modifications to Legacy Data
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $remark = $Pcases->dag_no . ", এই দাগৰ ";
                        if($Pcases->suggested_dag_no != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Dag No</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="suggested_dag_no" value="'.$Pcases->suggested_dag_no.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."দাগ নং ".$Pcases->dag_no." পৰা ".$Pcases->suggested_dag_no.", ";
                        }
                        
                        if($Pcases->suggested_patta_no != '')
                        {
                                echo'<div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta No</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control suggested_patta_no" name="suggested_patta_no" data-remark="'. $Pcases->rmk_line_no .'" value="'.$Pcases->suggested_patta_no.'" readonly disabled>
                                        </div>
                                        <div class="msg" style="padding: 20px;text-align: center;"><label class="red">'. $patta_remarks .'</label></div>
                                        <div class="col-sm-12" id= "remark" style="border: 1px solid red;height:200px;overflow-y:scroll;width:100%;"></div>
                                    </div>';
                                    // if($patta_remarks){
                                    //     echo '<div style="padding: 20px;text-align: center;"><label class="red">'.$patta_remarks.'</label></div>';
                                    // }
                                    //  echo'</div>';
                                $remark = $remark.""."পট্টা নং ".$Pcases->patta_no." পৰা ".$Pcases->suggested_patta_no.", ";
                        }
                        
                        if($Pcases->suggested_patta_type != '0' && $Pcases->suggested_patta_type !='')
                        {
                              echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta Type</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_patta_type" value="'.$new_patta_type.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."পট্টা প্ৰকাৰ ".$det['patta_type']." পৰা ".$new_patta_type.", ";
                        }
                        
                        if($Pcases->suggested_land_class != '0' && $Pcases->suggested_land_class != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Land Class</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_land_class" value="'.$new_land_class.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."মাঢি শ্ৰেণী ".$det['old_land_class']." পৰা ".$new_land_class.", ";
                        }
                        
                        if($Pcases->suggested_land_rev != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Revenue</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_land_rev" value="'.$Pcases->suggested_land_rev.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."মাঢি ৰাজহ ".$Pcases->present_land_revenue." পৰা ".$Pcases->suggested_land_rev.", ";
                        }
                        
                        if($Pcases->suggested_loc_tax != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Local Tax</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_local_tax" value="'.$Pcases->suggested_loc_tax.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."মাঢি স্হানীয় কৰ ".$Pcases->present_land_localtax." পৰা ".$Pcases->suggested_loc_tax.", ";
                        }
                        
                        
                         if($Pcases->suggested_pattadarstrike != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Pattadar Strike</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_pattadar_strike" value="'.$Pcases->suggested_pattadarstrike.'" readonly disabled>
                                    </div>
                                    </div>';
                                $remark = $remark.""."কাটিব লগা পট্টাদাৰৰ  নাম ".$Pcases->suggested_pattadarstrike.", ";
                        }
                        
                        
                        //#START PLB
                        
                        // $dist_code = $this->session->userdata('dist_code');
                        if(in_array($Pcases->dist_code, json_decode(BARAK_VALLEY))){
                            if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != '') && ($Pcases->suggested_dag_area_g != '') && ($Pcases->suggested_dag_area_kr != ''))
                            {
                                echo'<div class="form-group alert  sugested_area px-0 mx-0">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="ass-btn">Suggested Area</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_b.' বি" readonly disabled>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: inherit;">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_k.' ক" readonly disabled>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: inherit;">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_lc.' ছ" readonly disabled>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: inherit;">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_g.' গ" readonly disabled>
                                    </div>

                                </div>';
                                    $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." ছ ".$Pcases->dag_area_g." গ পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." ছ ".$Pcases->suggested_dag_area_g." গ ";
                            }
                        }else{

                            if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != ''))
                            {
                                echo'<div class="form-group alert  sugested_area">
                                    <label for="inputEmail3" class="col-sm-5 control-label"><span class="ass-btn">Suggested Area</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_b.' বি" readonly disabled>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: inherit;">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_k.' ক" readonly disabled>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <input type="text" class="form-control" value="'.$Pcases->suggested_dag_area_lc.' লে" readonly disabled>
                                    </div>
                                </div>';
                                $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." লে পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." লে ";
                            }

                        }?>

                        <!--#END PLB-->
                       
                        <hr style="border-bottom: 2px solid #000;">
                         <div class="col-sm-12">
                            <label class="control-label col-sm-6" style="display: inline-block;">
                                <input type="radio" name="order_type" value="forward_to_dc" onclick="return confirm('Are you sure you dont want to forward it to DC/ADC (S) ?')" required> Forward to DC / ADC  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label>
                            <?php if($app && $app->basundhara): ?>
                                <label class="control-label" style="display: inline-block;">    
                                    <input type="radio" name="order_type" value="co_order" required> Pass Order Anyways.
                                </label>
                            <?php endif; ?>
                            <!-- <label class="control-label  col-sm-12" style="display: inline-block;">    
                                <center><input type="radio" name="order_type" value="reject" onclick="return confirm('Are you sure you want to Reject Case ?')" required> Reject Case. ( Write Reason For Rejection Below )</center>
                            </label> -->
                            <hr>
                        </div>

                        

                        <h2><mark>Circle Officer(s) Note On Action or Reason For Rejection</mark></h2>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    // echo '<textarea name="" readonly="" class="form-control final" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  '.$remark.' সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ - '.$location['co_name'] . ", চক্র বিষয়া, " . $location['cir'].'</textarea>';
                                    // echo '<textarea name="final_report" class="form-control" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  '.$remark.' সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ - '.$location['co_name'] . ", চক্র বিষয়া, " . $location['cir'].'</textarea>';
                                    echo '<textarea name="final_report" class="form-control" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  '.$remark.' সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷</textarea>';
                                    ?>
                                    <textarea name="" class="form-control reject" rows="5">তথ্য নাই | - <?php echo $location['co_name'] . ", "; ?><?php echo "চক্র বিষয়া, " . $location['cir']; ?></textarea>
                                    <textarea name="" readonly="" class="form-control forward" rows="5">হাতৰ চিঠাৰ তথ্য  ৰ ভিতিত উক্ত দাগত তথ্যৰ সংশোধনী কৰি উপৰোক্ত সংশোধন কেইটা উপায়ুক্ত / অতিৰিক্ত উপায়ুক্ত অনুমোদনৰ বাবে দিয়া হল ৷</textarea>
                                    <!-- <textarea name="designation_suffix" class="form-control hide" rows="5"><?php //echo $location['co_name'] . ", "; ?><?php //echo "চক্র বিষয়া, " . $location['cir']; ?></textarea> -->
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                </div>
                                <hr>
                                
                                <div class="col-lg-12" id="dc_block">
                                    <label class="rasid col-sm-12">
                                        Note : Please Select the Forwarding Officer (Deputy Commissioner / Assistant Deputy Commissioner) 
                                    </label>
                                    <center>
                                        <label class="rasid btn">Please Select DC/ADC &nbsp;&nbsp;</label>
                                        <label class="btn btn-success">
                                            <select class="form-control" name='dc_code' id="dc_code" required>
                                                <?php
                                                echo"<option disabled selected> -- Select --</option>";
                                                foreach ($dc_adc as $dcadc) {
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
                                <div class="col-lg-12" id="co_block">
                                    <label class="rasid col-sm-12">
                                          <input type="checkbox" id="myCheck" onclick="myFunction()">   স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হম ৷   
                                    </label>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">

                            <?php if(!empty($app->basundhara)){ ?>

                            <center>
                          <?php if($buttonEnabledFlag==1){?> 
                            <button class="btn revertToLmModal btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#revertModal"><i class="fa fa-arrows-alt"></i> Revert Application</button>    
                          <button type="submit" class="btn btn-sm btn-primary" id="change_text1"><i class='fa fa-check-square-o'></i> Submit</button>&nbsp;
                      <?php }?>
                          <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$Pcases->case_no?>','<?=SERVICE_AREA_CORRECTION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                          <!-- <button class="btn reject btn-sm btn-danger" id="reject_text1"><i class='fa fa-check'></i> Reject Application</button>&nbsp; -->

                         <!-- <button type="submit" class="btn btn-sm btn-danger" id="reject_text"><i class='fa fa-check'></i>&nbsp; Reject 
                            <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
              <input type="hidden" class="form-control" name='case_no' value="<?php //echo $Pcases->case_no; ?>">
            <input type="hidden" class="form-control" name='proposal_no' value="<?php //echo $Pcases->proposal_no; ?>">

                         </button> -->

                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      

                            <?php }

                             else { ?>

                            <div class="form-group">
                                <center>
                                <div class="col-lg-12">
                                    <?php if($buttonEnabledFlag==1){?> 
                                        <button class="btn revertToLmModal btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#revertModal"><i class="fa fa-arrows-alt"></i> Revert Application</button>
                                        <button type="submit" class="btn btn-success" id="change_text1"><i class='fa fa-check'></i>&nbsp;Submit To Forward Report</button>
                                    <?php }?>
                                    <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$Pcases->case_no?>','<?=SERVICE_AREA_CORRECTION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>


                                </div>
                                </center>
                            </div>
                            <?php }?>
                    </div>
                </div>
            </div>
        
         </form>
        </div>
    </div>
</div>

<form style="display: none;">
    <textarea name="designation_suffix" class="form-control hide" rows="5"><?php //echo $location['co_name'] . ", "; ?><?php //echo "চক্র বিষয়া, " . $location['cir']; ?></textarea>
</form>

<!-- <div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/basundhara/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->

<!-- <div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/LegacyDataUpdation/reject" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
              <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>">
            <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>"> 
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
                if($this->session->flashdata('query_mdl_message')){
            ?>
                <div class="alert alert-warning alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong class="text-danger">
                        <?= $this->session->flashdata('query_mdl_message'); ?>
                    </strong>
                </div>
            <?php
                }
            ?>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
            <div class="modal-body">
                <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>

<div id="revertModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Revert this case</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form id='revertRequest' action="<?php echo base_url('index.php/legacy-data-updation/revert') ?>" method="post">
                <input type="hidden" class="form-control" name='case_no' value="<?= $Pcases->case_no; ?>">
                <div class="modal-body">
                    <textarea name='remark' class="form-control" placeholder="Please enter your reason"></textarea>
                    <strong class="text-danger revert_error_msg"></strong>
                </div>
                <div class="modal-footer">
                    <button type="submit" id='revertSend' class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="historyModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Case (<?= $Pcases->case_no; ?>) Histories</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body history_section">
                <div class="text-center">Fetching data...</div>
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
$('#dc_block').hide();
$('#co_block').hide();
$('.forward').hide();
$('.reject').hide();
$("#reject_text").attr('disabled', true);

    // $("input[name='order_type']").click(function() {
    $("input[name='order_type']").change(function() {
        // console.log("value"+$(this).val());
        if ($(this).is(':checked') && $(this).val()=='forward_to_dc'){
            $('#dc_block').show();
            $('#co_block').hide();
            $('.forward').show();
            $('.final').hide();
            $('.reject').hide();
            $('#change_text1').innerHTML = "Submit To Forward Report";
            $("#change_text1").attr('disabled', true);
            $("#reject_text1").attr('disabled', true);
            $("#reject_text").attr('disabled', true);
            $(".forward").attr("name", "co_report");
            // console.log("forward complete");
        } else if ($(this).val()=='reject'){
            $('#dc_block').hide();
            $('#co_block').hide();
            $('.forward').hide();
            $('.final').hide();
            $('.reject').show();
            $('#change_text1').innerHTML = "Submit To Forward Report";
            $("#change_text1").attr('disabled', true);
            $('#reject_text1').removeAttr('disabled', false);
            $('#reject_text').removeAttr('disabled', false);
            $(".reject").attr("name", "co_report");
            // console.log("reject complete");
        } else {
            // console.log('Co order');
            $('#co_block').show();
            $('#dc_block').hide();
            $('.forward').hide();
            $('.final').show();
            $('.reject').hide();
            $('#change_text1').innerHTML = "Go For Correction";
            $(".final").attr("name", "co_report");
            $("#change_text1").attr('disabled', true);
            $('#reject_text').attr('disabled', true);
            console.log("co complete");
        }
    });

$("#change_text1").attr('disabled', true);
$("#reject_text1").attr('disabled', true);

$('#dc_code').change(function(){
    $('#change_text1').removeAttr('disabled', false);
});

$(document).ready(function(){
    getRemarks();
});

function getRemarks(){
    const patta_no = $('.patta_no_val').val();
    const patta_code = $('.patta_code_val').data('val');
    const remark = $('.suggested_patta_no').attr('data-remark');

    $.ajax({
        url: baseurl + "LegacyDataUpdation/getRemarksJSON/" + patta_no + "/" + patta_code,
        success: function (data) {
            var rmk = JSON.parse(data);
            var template = "";
            let remarksArr = [];
            if(remark != undefined && remark != ''){
                remarksArr = remark.split(',');
            }
            
            for (var i = 0; i < rmk.length; i++) {
                // let checked = '';
                if($.inArray(rmk[i].rmk_line_no, remarksArr) >= 0){
                    // checked = 'checked';
                    template += `<label class="block-label" for="radio-1">
                                    <i class="fa fa-check-square text-primary"></i>
                                    <input type="hidden" id="checkbox" name="remark[]" value="${rmk[i].rmk_line_no}" readonly disabled />
                                    &nbsp;&nbsp;${rmk[i].remark}</label>
                                <hr style="border-bottom: 1px solid #000;">`;
                }
            }
            
            $('#remark').html(template);
        }
    });
}

function myFunction() {
  var checkBox = document.getElementById("myCheck");
  if (checkBox.checked == true){
    $('#change_text1').removeAttr('disabled', false);
  } else {
    $('#change_text1').attr('disabled', true);
  }
}

$('#revertRequest').on('submit', function(e){
    e.preventDefault();

    $('.revert_error_msg').html('');
    let form = $(this);
    let formData = new FormData(this);
    $('#revertSend').text('Please Wait...').attr('disabled', true);

    $.ajax({
        method: 'POST',
        data        : formData,
        url         : form.attr('action'),
        processData : false, // Don't process the files
        contentType : false, // Set content type to false as jQuery will tell the server its a query string request
        dataType    : 'json',
        success     : function(response){
            $('#revertSend').text('Save');
            if(response.responseType == 2)
            {
                Swal.fire({
                    'icon': 'success',
                    'title': response.message,
                }).then(() => {
                    window.location.href = response.redirectUrl;
                });
            }
            else
            {
                $('#revertSend').attr('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: response.message
                });
            }
        },
        error       : function(data){
            $('#revertSend').text('Save').attr('disabled', false);
            var errors = data.responseJSON;
            $('.revert_error_msg').html(errors.message);
            // Swal.fire({
            //     icon: 'error',
            //     title: errors.message
            // });
            
            
        }
    });
});

$(document).on('click', '.get_history', function(){
    if(!$(this).hasClass('fetched_history')){
        const $this = $(this);
        const caseNo = $this.data('case_no');
        const actionUrl = "<?= base_url('index.php/legacy-data-updation/get-history') ?>";
        $.ajax({
            method: 'POST',
            data        : {
                                case_no : caseNo
                            },
            url         : actionUrl,
            success     : function(response){
                if(response.responseType == 2)
                {
                    $('.history_section').html(response.data.html);
                    $this.addClass('fetched_history');
                }
                else
                {
                    $('.history_section').html('Please try again later');
                    Swal.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error       : function(data){
                $('.history_section').html('Please try again later');
                // var errors = data.responseJSON;
                Swal.fire({
                    icon: 'error',
                    title: data.message
                });
                
                
            }
        });
    }

});

</script>



