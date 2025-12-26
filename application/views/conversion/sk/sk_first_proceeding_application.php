<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header text-center">
                <h5><?php echo $this->lang->line('application_description'); ?></h5>
            </div>
            <div class="card-body">
                <h4 class="mt-2"><?php echo $this->lang->line('general_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-bold table-success">
                            <th><label><?php echo $this->lang->line('district'); ?></label></th>
                            <th><label><?php echo $this->lang->line('subdivision'); ?></label></th>
                            <th><label><?php echo $this->lang->line('circle'); ?></label></th>
                            <th><label><?php echo $this->lang->line('lot_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('mouza'); ?></label></th>
                            <th><label><?php echo $this->lang->line('vill_town'); ?></label></th>
                            <th><label><?php echo $this->lang->line('type'); ?></label></th>
                            <th><label><?php echo $this->lang->line('address_to_the_officer'); ?></label></th>
                            <th><label><?php echo $this->lang->line('submission_date'); ?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $this->utilityclass->getDistrictName($app->dist_code); ?></td>
                            <td><?php echo $this->utilityclass->getSubDivName($app->dist_code, $app->subdiv_code); ?></td>
                            <td><?php echo $this->utilityclass->getCircleName($app->dist_code, $app->subdiv_code, $app->cir_code); ?></td>
                            <td><?php echo $this->utilityclass->getLotName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code, $app->lot_no); ?></td>
                            <td><?php echo $this->utilityclass->getMouzaName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code); ?></td>
                            <td><?php echo $this->utilityclass->getVillageName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code, $app->lot_no, $app->village_code); ?></td>
                            <td><?php echo $conv_type; ?></td>
                            <td><?php echo $add_to; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($app->date_submission)); ?></td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="mt-4"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-bold table-success">
                            <th><label><?php echo $this->lang->line('dag_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                            <th><label><?php echo $this->lang->line('patta_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('patta_type'); ?></label></th>
                            <!-- <th><label><?php echo $this->lang->line('show_chitha'); ?></label></th>
                            <th><label><?php echo $this->lang->line('show_jamabandi'); ?></label></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $chitha_basic->dag_no; ?></td>
                            <?php if(!in_array($app->dist_code, json_decode(BARAK_VALLEY))) { ?>
                                <td><?php echo $firstParty[0]->area_b . " বিঘা " . $firstParty[0]->area_k . " কঠা " . $firstParty[0]->area_lc . " লেছা " ?></td>
                            <?php } else { ?>
                                <td><?php echo $firstParty[0]->area_b . " বিঘা " . $firstParty[0]->area_k . " কঠা " . $firstParty[0]->area_lc . " ছটাক " . $firstParty[0]->area_g . " গোণ্ডা "; ?></td>
                            <?php } ?>
                            <td><?php echo $app->patta_no; ?></td>
                            <td><?php echo $app->patta_type; ?></td>
                            <!-- <td><a class="btn btn-primary" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank">চিঠা চাওক</a></td>
                            <td><a class="btn btn-primary" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank">জমাবন্দী চাওক</a></td> -->
                        </tr>
                    </tbody>
                </table>
                <h4 class="mt-4"><?php echo $this->lang->line('applicant_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-bold table-success">
                            <th><label><?php echo $this->lang->line('sl_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                            <th><label><?php echo $this->lang->line('guardian_name'); ?></label></th>
                            <th><label><?php echo $this->lang->line('relation'); ?></label></th>
                            <th><label><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                            <th><label>AADHAAR/PAN Status</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            <?php
                                $count = 1;
                                foreach ($firstParty as $p):
                                    $flag = 'N/A';
                                    if($p->auth_type == 'AADHAAR'){
                                        $flag = 'AADHAAR Verified';
                                    }else if($p->auth_type == 'PAN'){
                                        $flag = 'PAN Verified';
                                    }
                                    $pdar_name = $p->name_ass;
                                    $relation = $p->gurdian_relation_id;
                                    $relationship = $this->utilityclass->get_relation_from_id($relation);
                                
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $pdar_name; ?></td>
                                    <td><?php echo $p->gurdian_name_ass; ?></td>
                                    <td><?php echo $relationship; ?></td>
                                    <td><?php echo $p->address; ?></td>
                                    <td><?php echo $flag; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>

            
            <div class="card-body">
            <h4 class="mt-4">Self Declaration</h4>
            <table class="table table-bordered">
                <?php foreach ($selfDecData[0] as $key => $self) { 
                    
                    ?>
                    <tr>
                        <th><?=$self->name?></th>
                        <td>
                            <strong>
                                <?php if ($self->name=='I belong to the category'){
                                    if ($self->status == "1") {echo "ST/SC/OBC/MOBC";}
                                    if ($self->status == "0") {echo "General";}
                                    } else {
                                 ?>
                                <?php if ($self->status == "1") {echo "Yes";}?>
                                <?php if ($self->status == "0") {echo "No";} }?>
                            </strong>
                        </td>
                    </tr>
                <?php }?>
            </table>
            </div>

            <div class="card-footer">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <?php
                            if($basundhar_application){
                                echo '<h6 class="red">Other Attachments</h6>';
                                foreach ($basundhara_attachment  as $attachment):
                                ?>
                                    <p><a href="<?php echo base_url()."index.php/basundhara3/document/".$attachment->name  ?>" class="red fs-6" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></p>
                                <?php 
                                endforeach;
                            }
                            else{
                                echo '<h6 class="red">Other Attachments</h6>';
                                foreach($supportive_documents as $docs):
                                ?>
                                    <p><a class="red fs-6" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></p>
                                <?php
                                endforeach;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

