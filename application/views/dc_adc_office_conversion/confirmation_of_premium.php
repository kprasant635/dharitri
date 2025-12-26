<div class="row login panel-form">
<div class="col-lg-10 col-lg-offset-1">
<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <p class='center bold uni_text'><u><?php echo $this->lang->line('case_no_mutation_premium_details');?></u></p>
                <p class='center bold uni_text'><u><?php echo $this->lang->line('case_no');?> : <?php echo $location['case_no'];?></u></p>
            </div>
        </div>
        <div class="panel-body">
            <?php 
            $proceed=1;
            if($basundharaExist){
                    if($success->payment_status=='Y'){
                        $proceed=0;
                ?>
                <h4>Payment successfully completed through GRN No: <?=$success->grn_no?>
                        <br><br><br>
                        <strong style="color:red">NOTE: Please verify GRN/challan before payment onfirmtaion <a style="color:blue" target="_blank" href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php">Click here to verify</a></strong>
                </h4>
                <form class="" method='post' action="<?php echo base_url() . "index.php/AdcConversionMb/confirmation_premium_save"; ?>">
                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                    <input type="hidden" name="date" value="<?php echo $success->payment_date; ?>"/>
                    <center><button type="submit" name="paymentBasu" class="btn btn-success uni_text" value="true"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button></center>
                </form> 
            <?php
                }else{
                    $proceed=1;
                    echo "<h4>Payment not Completed by the USER</h4>";
                ?>
                    <h6><a href="<?php echo base_url()."index.php/AdcConversionMb/cancelPremium?case_no=".$location['case_no']  ?>" class="green pull-right" >&nbsp;&nbsp;Click Here to Cancel Premium Notice & Revert to CO <sup class="red">New</sup></a></h6>
                    <br>
            <?php
                }
             } 
             if ($proceed==1){

                 ?>
            <form class="" method='post' enctype="multipart/form-data" action="<?php echo base_url() . "index.php/AdcConversionMb/confirmation_premium_save"; ?>">
            <div class="row">
                <div class="col-lg-12">
                    <p align="right" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                        <?php //echo $this->lang->line('name'); ?> : 
                        <?php
                        foreach ($pattadar as $pop):
                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                        endforeach;
                        ?>
                    </p>
                    <table class='table table-striped'>
                        <tr style="text-align: center;">
                            <?php 
                                if ((($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) || ($lm_details['dist_frm_town'] == '3') || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm'))) {
                                    if (trim($lm_details['premium_assesment']) == '40' || trim($lm_details['premium_assesment']) == '20') {
                                        $prem_percent= $lm_details['premium_assesment'];
                                    }else {
                                        $prem_percent = $lm_details['prim_per_bigha'];
                                    }
                                }else{
                                    $prem_percent = $lm_details['prim_per_bigha'];
                                }
                                ?>
                            <td colspan="4"><p class="rasid" >বিঘাই প্রতি <span style="color:#37BC9B"><?=$prem_percent ?> টকা</span> হাৰে <?php echo $lm_details['dag_no']; ?> নং দাগৰ <?php echo $lm_details['conv_b']; ?> বিঘা, <?php echo $lm_details['conv_k']; ?> কঠা, <?php echo $lm_details['conv_lc']; ?> লেছা মাটিৰ <span style="color:#37BC9B">প্রিমিয়াম হয় = <?php echo $lm_details['prim_tot']; ?> টকা</span> ।</p></td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr style="text-align: center;">
                            <td><label class="control-label" ><?php echo $this->lang->line('type_of_premium');?></label></td>
                            <td>
                                <select name="payment_type" class="form-control" id="payment_type">
                                    <option selected disabled>Select Payment Type</option>
                                    <?php foreach ($payment_type as $pay): ?>
                                    <option value="<?php echo $pay->code;?>"><?php echo $pay->chalan_name;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><div id="recpt1"><label class="control-label" ><?php echo $this->lang->line('premium_chalan_receipt_no');?></label></div></td>
                            <td>
                                <div id="recpt2"><input type="text" name="chalan_no" class="form-control" id="chalan_no" maxlength="50" required/></div>
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td colspan="4"><label class="control-label" ><?php echo $this->lang->line('total_premium');?> = <?php echo $lm_details['prim_tot']; ?></label></td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 required  control-label">Upload Premium Challan</label>
                                <div class="col-lg-3">
                                    <input type='file' name="up_prem_conv" id="up_prem_conv" required>
                                </div>
                                <div class="col-lg-3">
                                    <label>Payment Date</label>
                                    <input type="date" name="payment_date" id="payment_date" class="" required />
                                </div>
                                
                                <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-6" align="right">
                        <button type="submit" name="submit2" class="btn btn-danger uni_text" value="false" onclick="return confirm('Are you sure you want to Proceed Without Paying any Premium?')"><i class='fa fa-times'></i>  <?php echo $this->lang->line('no_premium');?></button>
                    </div>

                    <div class="col-lg-6">
                        <input type="hidden" name="premium_amount" value="<?php echo $lm_details['prim_tot']; ?>"/>
                        <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                        <button type="submit" name="submit1" class="btn btn-success uni_text btnprem" value="true"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button>
                        <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/AdcConversionMb/GoToBo?pro=4"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                    </div>
                </div>
            </div>
            </form>
            <div class="col-lg-12 alert alert-warning">
                <div class="col-lg-12 center">
                    <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                    <button type="" class="btn btn-info uni_text" value="2" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;<?php echo $this->lang->line('lm_report'); ?></button>
                    <button type="" class="btn btn-active uni_text" value="3" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;  AST & CO Report</button>
                    <!-- <button type="" class="btn btn-default uni_text" value="4" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('sk_report'); ?></button>
                    <button type="" class="btn btn-primary uni_text" value="6" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; BO Report</button>
                    <button type="" class="btn btn-warning uni_text" value="5" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('view_premiun_report'); ?></button>
                    <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=2"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a> -->
                </div>
            </div>
        <?php 
                 } ?>
        </div>
</div>
</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title uni_text"><?php echo $this->lang->line('application_description'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row panel-form">
                    <div class="col-lg-12 center-col">
                        <div class="panel">
                            <!--div 1-->         
                            <div id="notice1" style='display: none'>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <p class='center uni_text'> <?php echo $this->lang->line('application_description'); ?></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                                        <table class='table table-bordered unicode'>
                                            <tr>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                                <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $location['add_to']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($location['date'])); ?></label></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                                        <table class="table table-bordered  unicode">
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td><label class="control-label"><?php echo $land_details['dag']; ?></label></td>
                                                <td><label class="control-label"><?php echo $land_details['m_dag_area_b'] . " বিঘা " . $land_details['m_dag_area_k'] . " কঠা " . $land_details['m_dag_area_lc'] . " লেছা " ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $land_details['patta_no']; ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=4&dist=" . $l_data['dist_code'] ."&sub_div=".$l_data['subdiv_code']."&cir=".$l_data['cir_code']."&m=".$l_data['mouza_pargona_code']."&l=".$l_data['lot_no']."&v=".$l_data['vill_code']."&p=".$land_details['patta_type']."&dag=".$land_details['dag']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">জমাবন্দী চাওক</span></button></a></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                                        <table class='table table-bordered  unicode'>
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                                </tr>
                                            </thead>
                                            <?php $count = 1; ?>
                                            <?php
                                            foreach ($pattadar as $p):
                                                $pattadar = $p->name_ass;
                                                //$relation=$p->pdar_rel_guar;
                                                $relation = 'f';
                                                $relationship = $this->utilityclass->get_relation($relation);
                                                ?>
                                                <tr>
                                                    <td><label class="control-label"><?php echo $count++; ?></label></td>
                                                    <td><label class="control-label"><?php echo $pattadar; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->gurdian_name_ass; ?></label></td>
                                                    <td><label class="control-label"><?php echo $relationship; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->address; ?></label></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <!--div 2-->            
                            <div id="notice2" style='display: none'>
                                <?php
                                if (count($lm_details_final) != 0) {
                                    foreach ($lm_details_final as $lm):
                                        ?>
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> (<?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                                <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?>  <?php echo $land_details['dag']; ?>)</span></p>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class='table table-striped unicode'>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; - 
                                                                    <?php
                                                                    if ($lm->applicant_patta_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                                                    <?php
                                                                    if ($lm->occupied_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                                                    <?php
                                                                    if ($lm->val_tree_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী - <?php echo $lm_details['land_class_code']; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                                                    <?php
                                                                    if ($lm->issuit_forconv_under105 == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ </label>
                                                                <!-- added by hridayjit -->
                                                                <?php if($lm->roadside_old_new_dag_reservation != null) {?>
                                                                    </label class="control-label"> <b>Roadside Reservation: </b> 
                                                                        <?php 
                                                                            if($lm->roadside_old_new_dag_reservation == 'newdagreservation')
                                                                            {
                                                                                echo 'New Dag Reservation';
                                                                            } 
                                                                            else if($lm->roadside_old_new_dag_reservation == 'olddagreservation') 
                                                                            {
                                                                                echo 'Old Dag Reservation';
                                                                            }; 
                                                                        ?>
                                                                    </label>
                                                                <?php } ?>
                                                                <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৭) উক্ত মাটি নদীৰ কাষৰ মাটি &nbsp; -
                                                                    <?php
                                                                    if ($lm->near_river_yn == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                                    <!-- added by hridayjit -->
                                                                    <?php if($lm->riverside_old_new_dag_reservation != null) { ?>
                                                                        <label class="control-label"> <b>Riverside Reservation: </b>
                                                                            <?php 
                                                                                if($lm->riverside_old_new_dag_reservation == 'newdagreservation')
                                                                                {
                                                                                    echo 'New Dag Reservation';
                                                                                } 
                                                                                else if($lm->riverside_old_new_dag_reservation == 'olddagreservation') 
                                                                                {
                                                                                    echo 'Old Dag Reservation';
                                                                                }; 
                                                                            ?>
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label> 
                                                                <ul>
                                                                <?php
                                                                if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                                                {
                                                                    $msg="";
                                                                    echo " - এই আবেদনত উপযোগী নহয় |";
                                                                }
                                                                else{
                                                                    $msg="আৰু ২৫% ৰেহাই পাচত";
                                                                }
                                                                if ($lm->jati_janajati_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';

                                                                        if(empty($lm->jati_janajati_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                } 
                                                                if ($lm->freedom_fighter_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->freedom_fighter_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                if ($lm->widow_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->widow_yn_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <?php 
                                                                    // muzammil : new include file added for premium condition 
                                                                    // include(APPPATH."views/inc/conversion_premium.php");?>
                                                                    <label class="control-label" >
                                                                    ৯) 
                                                                    <?php

                                                                        echo $conversion_premium_area->ass_name . ' মাটি - হয়';

                                                                    ?>
                                                                    </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            <?php // muzammil : new include file added for premium per bigha 
                                                            include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                                                <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?=round($bigha_prem, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%"><label class="control-label">১১) মন্ডলৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                            <td><label class="control-label"><?php echo $lm->partition_info; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১২) লাঃ মঃ ৰ চহী &nbsp; - 
                                                                    <?php
                                                                    if ($lm->lm_sign_yn == 'Y' || $lm->lm_sign_yn == 'y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৩) লাঃ মঃ ৰ নাম &nbsp; - <?php echo $lm_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৪) লাঃ মঃ এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->date_entry)); ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Pattadar Name</th>
                                                                            <th>Inplace / Alongwith</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($p_in_order as $pdar) { ?>
                                                                            <tr>
                                                                                <td><?php echo $pdar->pdar_name; ?></td>
                                                                                <td><?php echo $pdar->inplace_alongwith; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> ( <?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                            <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?> <?php echo $land_details['dag']; ?>)</span></p>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        No Report found
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--div 3-->            
                            <div id="notice3" style='display: none'>
                                <div class="panel-heading">
                                    <p align="left" class="uni_text"> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ </p><br>
                                    <p align="right" style="margin-top: 0; margin-bottom: 0">
                                        <font size="3" face="courier">
                                        <?php echo $this->lang->line('name'); ?> : 
                                        <?php
                                        foreach ($p_in_order as $pop):
                                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                        endforeach;
                                        ?>
                                        </font>
                                    </p>
                                    <div class="panel-title">
                                        <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                                        <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                                        <br>
                                        <p class='center bold uni_text'><span class="">Order Sheet, dated from <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['date'])); ?></span> To <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['next_date'])); ?></span> District <?php echo $location['dist']; ?> <br>
                                                Case No <?php echo $location['case_no']; ?></span></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                            <table class="table table-bordered" style="font-size: 16px;">
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>Serial No and Date of Order</td>
                                                    <td width="40%">Order and Signature of Officer</td>
                                                    <td width="40%">Note Of Action Taken on Order</td>
                                                </tr>
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>১</td>
                                                    <td>২</td>
                                                    <td>৩</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($cases as $case):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                                        <td>
                                                            <?php echo $case->co_order; ?></td>
                                                        <td>
                                                            <?php echo $case->note_on_order; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                                //$i = $i+1;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default uni_text" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function modaldiva(objButton) {
        if (objButton == 1)
        {
            document.getElementById('notice1').style.display = 'block';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 2)
        {
            document.getElementById('notice2').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 3)
        {
            document.getElementById('notice3').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 4)
        {
            document.getElementById('notice4').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 5)
        {
            document.getElementById('notice5').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 6)
        {
            document.getElementById('notice6').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
    }

$('.btnprem').click(function(){
    if($('#up_prem_conv').val()==0){
        alert("Premium Challan upload is mandatory");
        $('#up_prem_conv').focus();
        return false;
    }
});

$(document).ready(function () {
    $('#payment_type').change(function () {
        var data = $(this).val();
        //alert (data);
        if (data == '003') 
        {
            $('#recpt1').hide();
            $('#recpt2').hide();
            $('#report3').hide();
            $('#report4').show();
        }
        else 
        {
            $('#recpt1').show();
            $('#recpt2').show();
            $('#report3').show();
            $('#report4').hide();
        }
    });
    let btnNameAttr;
    let btnValAttr;

    $('button').click(function(){
        btnNameAttr = $(this).attr('name');
        btnValAttr = $(this).attr('value');
    });

    $('form').on('submit', function(){
        $('.submit_input').remove();
        $('form').append(`<input type="hidden" class="submit_input" name="${btnNameAttr}" value="${btnValAttr}">`);
    });   
});

</script>
