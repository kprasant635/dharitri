<style>
	.text-style {color:red;}
</style>

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
            

            <form class='form-horizontal' id="f1" method="post" action="<?php echo base_url('index.php/LegacyDataUpdation/SaveLmRevertProcess') ?>" enctype="multipart/form-data">
    
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
                                    <input type="text" class="form-control dag_no_val" name="dag_no" value="<?php echo $Pcases->dag_no; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control old_patta_code patta_no_val" name="patta_no" value = "<?php echo $Pcases->patta_no; ?>" readonly>
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
                                        <a href="<?php echo get_file_location('LDUDocs', $Pcases->file_upload, 'uploads_back_feb224'); ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;Verify Uploaded Documents
                                        </a>
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
                        $remark = "এই দাগৰ ";
                        if($Pcases->suggested_dag_no != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Dag No</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="suggested_dag_no" value="'.$Pcases->suggested_dag_no.'">
                                    </div>
                                    </div>';
                                $remark = $remark.""."দাগ নং ".$Pcases->dag_no." পৰা ".$Pcases->suggested_dag_no.", ";
                        }
                        
                        if($Pcases->suggested_patta_no != '')
                        {
                                echo'<div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta No</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control suggested_patta_no" data-remark="'. $Pcases->rmk_line_no .'" name="suggested_patta_no" id="suggested_patta_no" value="'.$Pcases->suggested_patta_no.'">
                                        </div>
                                        <div class="msg" style="padding: 20px;text-align: center;"><label class="red">'. $patta_remarks .'</label></div>
                                        <label for="inputEmail3" class="col-sm-12 red">Select the remarks that will be transfered in the new patta.</label>
                                        <div class="col-sm-12" id= "remark" style="border: 1px solid red;height:200px;overflow-y:scroll;width:100%;"></div>
                                    </div>';

                                    // <div class="col-sm-5">
                                    //     <input type="text" class="form-control" name="suggested_patta_no" value="'.$Pcases->suggested_patta_no.'">
                                    // </div>';
                                    // if($patta_remarks){
                                    //     // echo '<div style="padding: 20px;text-align: center;"><label class="red">'.$patta_remarks.'</label></div>';
                                    // }
                                    //  echo'</div>';
                                $remark = $remark.""."পট্টা নং ".$Pcases->patta_no." পৰা ".$Pcases->suggested_patta_no.", ";
                        }
                        
                        if($Pcases->suggested_patta_type != '0' && $Pcases->suggested_patta_type !='')
                        {
                            $suggested_patta_type_select = '<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta Type</label>
                                    <div class="col-sm-5">
                                    <select class="form-control " id="npc" name="suggested_patta_type">
                                        <option selected disabled value="">';
                                    //<input type="text" class="form-control" name="sugested_patta_type" value="'.$new_patta_type.'">
                            $suggested_patta_type_select .= $this->lang->line('select_patta_type') . '</option>';

                            foreach ($patta_code as $pc) {
                                $selected = '';
                                if($details->suggested_patta_type == $pc->type_code){
                                    $selected = 'selected';
                                }
                                $suggested_patta_type_select .= '<option value="'. $pc->type_code .'" '. $selected . '>'. $pc->patta_type . '</option>';
                            }
                            
                            $suggested_patta_type_select .= '</select></div></div>';

                            echo $suggested_patta_type_select;
                            $remark = $remark.""."পট্টা প্ৰকাৰ ".$det['patta_type']." পৰা ".$new_patta_type.", ";
                        }
                        
                        if($Pcases->suggested_land_class != '0' && $Pcases->suggested_land_class != '')
                        {
                                $suggested_land_class_select = '<div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">Suggested Land Class</label>
                                        <div class="col-sm-5">
                                            <!-- <input type="text" class="form-control" name="sugested_land_class" value="'.$new_land_class.'"> -->
                                            <select class="form-control" name="suggested_land_class" id="suggested_land_class">
                                                <option selected disabled value="">' . $this->lang->line('select_land_class') . '</option>';

                                foreach ($land_class as $lc) {
                                    $selected = '';
                                    if($details->suggested_land_class == $lc->class_code){
                                        $selected = 'selected';
                                    }
                                    $suggested_land_class_select .= '<option value="' . $lc->class_code . '" '. $selected .'>' . $lc->land_type . '</option>';
                                }

                                $suggested_land_class_select .= '</select></div></div>';

                                echo $suggested_land_class_select;

                                $remark = $remark.""."মাঢি শ্ৰেণী ".$det['old_land_class']." পৰা ".$new_land_class.", ";
                        }
                        
                        if($Pcases->suggested_land_rev != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Revenue</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_land_rev" value="'.$Pcases->suggested_land_rev.'">
                                    </div>
                                    </div>';
                                $remark = $remark.""."মাঢি ৰাজহ ".$Pcases->present_land_revenue." পৰা ".$Pcases->suggested_land_rev.", ";
                        }
                        
                        if($Pcases->suggested_loc_tax != '')
                        {
                                echo'<div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Suggested Local Tax</label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="sugested_local_tax" value="'.$Pcases->suggested_loc_tax.'">
                                    </div>
                                    </div>';
                                $remark = $remark.""."মাঢি স্হানীয় কৰ ".$Pcases->present_land_localtax." পৰা ".$Pcases->suggested_loc_tax.", ";
                        }
                        
                        
                         if($Pcases->suggested_pattadarstrike != '')
                        {
                                $suggested_pattadar_strike_select = '<div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">Suggested Pattadar Strike</label>
                                        <div class="col-sm-5">
                                        <!-- <input type="text" class="form-control" name="sugested_pattadar_strike" value="'.$Pcases->suggested_pattadarstrike.'"> -->
                                            <select class="form-control " id="striked" name="suggested_striked[]" data-selected_val="'. $Pcases->suggested_pattadarstrike .'" >
                                                <option selected disabled value="">'. $this->lang->line('select_pattadar') . '</option>
                                            </select>
                                        </div>
                                    </div>';

                                echo $suggested_pattadar_strike_select;


                                $remark = $remark.""."কাটিব লগা পট্টাদাৰৰ  নাম ".$Pcases->suggested_pattadarstrike.", ";
                        }
                        
                        
                        //#START PLB
                        
                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                        if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != '') && ($Pcases->suggested_dag_area_g != '') && ($Pcases->suggested_dag_area_kr != ''))
                        {
                            echo'<div class="form-group alert alert-success row sugested_area">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="ass-btn">Suggested Area</span></label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_b" value="'.$Pcases->suggested_dag_area_b.'" aria-describedby="inputGroupPrepend" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"> বি</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_k" value="'.$Pcases->suggested_dag_area_k.'" aria-describedby="inputGroupPrependK" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrependK"> ক</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_lc" value="'.$Pcases->suggested_dag_area_lc.'" aria-describedby="inputGroupPrependL" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrependL"> ছ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_g" value="'.$Pcases->suggested_dag_area_g.'" aria-describedby="inputGroupPrependL" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrependL"> গ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                                $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." ছ ".$Pcases->dag_area_g." গ পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." ছ ".$Pcases->suggested_dag_area_g." গ ";
                        }
                        }else{

                        if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != ''))
                            {
                                echo'<div class="form-group alert alert-success row sugested_area">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="ass-btn">Suggested Area</span></label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_b" value="'.$Pcases->suggested_dag_area_b.'" aria-describedby="inputGroupPrepend" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"> বি</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_k" value="'.$Pcases->suggested_dag_area_k.'" aria-describedby="inputGroupPrependK" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrependK"> ক</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="margin-left: inherit;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="suggested_dag_area_lc" value="'.$Pcases->suggested_dag_area_lc.'" aria-describedby="inputGroupPrependL" style="height:auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrependL"> লে</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                    $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." লে পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." লে ";
                                }

                            }?>

                            <!--#END PLB-->
                        
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-sm-12">
                                
                                <!-- <label class="control-label" style="display: inline-block;">    
                                    <input type="radio" name="order_type" value="co_order" required> Pass Order Anyways.
                                </label> -->
                                <!-- <label class="control-label  col-sm-12" style="display: inline-block;">    
                                    <center><input type="radio" name="order_type" value="reject" onclick="return confirm('Are you sure you want to Reject Case ?')" required> Reject Case. ( Write Reason For Rejection Below )</center>
                                </label> -->
                                <hr>
                            </div>

                            

                            <h2><mark>LM Note On Reforwarding</mark></h2>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <?php
                                        // echo '<textarea name="" readonly="" class="form-control final" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  '.$remark.' সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ - '.$location['co_name'] . ", চক্র বিষয়া, " . $location['cir'].'</textarea>';
                                        echo '<textarea name="final_report" class="form-control" rows="5">' . $Pcases->dag_no . ', ' .$remark.' গোচৰ নং ' .  $Pcases->case_no .' চক্ৰ বিষয়াৰ সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ </textarea>';
                                    ?>
                                    <!-- <textarea name="designation_suffix" class="form-control hide" rows="5"><?php //echo $location['co_name'] . ", "; ?><?php //echo "চক্র বিষয়া, " . $location['cir']; ?></textarea> -->
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                </div>
                                <hr>
                                
                            </div>
                            <hr style="border-bottom: 2px solid #000;">

                            <?php 
                                if(!empty($app->basundhara)){ 
                            ?>

                                <center>
                                <?php if($buttonEnabledFlag==1){?> 
                            
                                    <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Submit</button>&nbsp;
                                <?php }?>

                                    <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                                </center>
                      

                            <?php 
                                }
                                else { 
                            ?>

                                    <div class="form-group">
                                        <center>
                                        <div class="col-lg-12">
                                            <?php if($buttonEnabledFlag==1){?> 
                                                <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;Submit To Forward Report</button>
                                            <?php }?>

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
        $("input[name='order_type']").click(function() {
        
        if ($(this).val()=='forward_to_dc'){
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
            console.log("forward complete");
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
            console.log("reject complete");
        } else {
            console.log('Co order');
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

$(document).ready(function(){
    getPattadars();
    getRemarks();
});

$("#change_text1").attr('disabled', true);
$("#reject_text1").attr('disabled', true);

$('#dc_code').change(function(){
    $('#change_text1').removeAttr('disabled', false);
});

$(".suggested_patta_no").blur(function () {
    // var pp = $(".patta_code option:selected").val();
    // var pp = $(".old_patta_code").val();
    var p = $('.suggested_patta_no').val();
    const patta_code = $('.patta_code_val').data('val');
    $.ajax({
        url: baseurl + "LegacyDataUpdation/existPattaNo/" + p + "/" + patta_code,
        success: function (data) {
            // if (debug) {
            //     console.log(data);
            // }
            var data = JSON.parse(data);
            if (data['val'] == '') {
                $(".msg").show();
                var template = "<label class='red'>এই পট্টা নং নতুন পট্টা হয় |</label>";
                $(".msg").html(template);
            }
            if (data['val'] != '') {
                $(".msg").show();
                var template = "<label class='red'>"+data['val']+"</label>";
                $(".msg").html(template);
            }

        }
    });
});

function getPattadars(){
    const dag_no = $('.dag_no_val').val();
    const patta_no = $('.patta_no_val').val();
    const patta_code = $('.patta_code_val').data('val');
    $.ajax({
        url: baseurl + "LegacyDataUpdation/getPattadarJSON/" + dag_no + "/" + patta_no + "/" + patta_code,
        
        success: function (data) {
            var ps = JSON.parse(data);
            
            var template = "<option selected disabled>Select Pattadar Name</option>";
            var count='0';
            for(var i= 0; i< ps.length ; i++){
                
                if(ps[i].p_flag=='1')
                count = parseInt(count) + 1;
                
            }

            const selectedVal = $('select[name="suggested_striked[]"]').attr('data-selected_val');            
            
            for (var i = 0; i < ps.length; i++) {
                let selected = '';
                if(ps[i].pdar_name == selectedVal){
                    selected = 'selected';
                }
                
                if((ps[i].p_flag=='0')&&((ps.length-count)=='1')){
                template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ps[i].pdar_name +  "' disabled " + selected + ">" + ps[i].pdar_name + "</option>";
                alert('Cannot strike out pattadar because there is only one unstriked pattadar left but you can unstrike pattadar');
                }
                
                else if((ps[i].p_flag=='0')&&((ps.length-count)!='1')){
                        template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ps[i].pdar_name +  "' " + selected + ">" + ps[i].pdar_name + "</option>";
                }
                
                else{
                    
                        template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ ps[i].pdar_name + "' class='text-style' " + selected + ">" + ps[i].pdar_name + "</option>";
                    
                }
            }
            
            
            // console.log(template);
            $('select[name="suggested_striked[]"]').html(template);
        }
    });
}

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
                let checked = '';
                if($.inArray(rmk[i].rmk_line_no, remarksArr) >= 0){
                    checked = 'checked';
                }
                template += '<label class="block-label" for="radio-1"><input type="checkbox" id="checkbox" name="remark[]" value="'+rmk[i].rmk_line_no+'" '+ checked +' />&nbsp;&nbsp;'+rmk[i].remark+'</label><hr style="border-bottom: 1px solid #000;">';
            }
            // console.log(template);
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



