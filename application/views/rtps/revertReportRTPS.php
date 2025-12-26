    <div class="container-fluid form-top login">
        <div class="row">
            <div class="col-lg-12 ">
                <?php if($this->session->flashdata('message')):?>
                <div class="col-lg-12 ">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                    </div>
                </div>
                <?php endif;?>
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="well well-sm">
                        <h2 style="text-align: center;">Office Mutation Revert Report (RTPS)</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <input type="hidden" value="<?=$this->input->get('case_no')?>" id="case_no">
                                <label class="col-sm-6 rasid">Case No : <?php echo $this->input->get('case_no'); ?></label>
                                <label class="col-sm-3 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                                <label class="col-sm-3 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                                <br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span style="color:#3c8198; font-size: 18px" class="bold"><?php echo $this->lang->line('general_information'); ?>
                                </span>
                                <table class='table table-bordered unicode'>
                                    <tr>
                                        <td width="35%"><label
                                            class="text-danger">Case No.
                                            : &nbsp;&nbsp;&nbsp;<?= $petition_basic ->case_no ?></label>
                                        </td>
                                        <td width="30%"><label
                                            class="text-danger">Transfer Type
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getTransferType($petition_basic ->trans_code) ?></label>
                                        </td>
                                        <td width="35%"><label
                                            class="text-danger">জিলা (District)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getDistrictName($petition_basic ->dist_code) ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label
                                            class="text-danger">মহকুমা (Sub Division)
                                            :
                                            &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getSubDivName($petition_basic ->dist_code, $petition_basic ->subdiv_code) ?></label>
                                        </td>
                                        <td><label
                                            class="text-danger">চক্র (Circle)
                                            :
                                            &nbsp;&nbsp;&nbsp; <?= $this->utilityclass->getCircleName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code) ?></label>
                                        </td>
                                        <td><label
                                            class="text-danger">মৌজা (Mouza)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getMouzaName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code) ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><label
                                            class="text-danger">লাট (Lot)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getLotName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code, $petition_basic ->lot_no) ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label
                                            class="text-danger">গাওঁ / চহৰ (Village) :
                                            <?= $this->utilityclass->getVillageName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code, $petition_basic ->lot_no, $petition_basic ->vill_townprt_code) ?></span>
                                        </label>
                                        </td>
                                        <td><label
                                            class="text-danger">Patta No.
                                            : &nbsp;&nbsp;&nbsp;<?= $petition_dag_details[0]->patta_no ?></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span style="color:#3c8198; font-size: 18px" class="bold">
                                <?php echo $this->lang->line('applicant_information'); ?> (First Party)
                            </span>
                            <table class='table table-bordered unicode'>
                                <thead>
                                    <tr>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('applicants_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                            / <?php echo $this->lang->line('address2'); ?></label>
                                        </th>
                                        <th><label class="text-danger">Land Area</label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="petitioner">
                                    <?php foreach ($petitioner as $key=>$applicant) {

                                        $bigha = (($applicant->applied_b==null)?'0':$applicant->applied_b);
                                        $katha = (($applicant->applied_k==null)?'0':$applicant->applied_k);
                                        $lessa = (($applicant->applied_lc==null)?'0':$applicant->applied_b);

                                        $land = 'B:'.$bigha.' / K:'.$katha.' / L:'.$lessa.' / Kr: 0';
                                        $add2 = $applicant->add2;

                                        ?>
                                        <tr id="<?=$applicant->pet_id?>" class="remove_<?=$applicant->pet_id?>">
                                            <td><?= $applicant->pet_name ?></label>
                                            </td>
                                            <td><?= $applicant->guard_name ?></label>
                                            </td>
                                            <td>Add 1: <?= $applicant->add1 ?><br>
                                            <?=(($add2=='')?'':'Add 2:'. $add2)?>
                                            </td>
                                            <td><label class="text-danger"><?=$land?></label></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
            
                        <div class="form-group" style="padding-left:10px;">
                             <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                                }
                            ?>   
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span style="color:#3c8198; font-size: 18px" class="bold">Pattadar Details (Second Party)
                            </span>
                            <table class='table table-bordered unicode'>
                                <thead>
                                    <tr>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger">Pattadar Name</label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                            / <?php echo $this->lang->line('address2'); ?></label>
                                        </th>
                                        <th><label class="text-danger">Inplace Alongwith</label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php foreach ($petition_pattadar as $key=>$pattadar) {?>
                                        <tr>
                                            <td><?= ++$key?></label>
                                            </td>
                                            <td><?= $pattadar->pdar_name ?></label>
                                            </td>
                                            <td><?= $pattadar->pdar_guardian ?></label>
                                            </td>
                                            <td>Add 1: <?= $pattadar->pdar_add1 ?>
                                            / Add 2: <?= $pattadar->pdar_add2 ?>
                                        </td>
                                        <td>
                                            <?php if($pattadar->striked_out == 1)
                                            { ?>
                                                Inplace
                                            <?php }
                                            else if($pattadar->striked_out == 0)
                                                { ?>
                                                    Alongwith
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 text-bold text-red" id="alert_message"></div>            
                        <form class="form-horizontal" action="<?=base_url().'index.php/Rtps/OfcMutationCOUpdateReport'?>" method="post" >
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <label for="inputEmail3"
                                class="uni_text control-label required">Type Note</label>
                                <textarea class="form-control" rows="5" name='note_order' id="note_order" placeholder="Please Type Your Report"></textarea>
                            </div>
                            <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>