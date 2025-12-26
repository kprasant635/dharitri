<?php

?>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h2><?php echo $this->lang->line('application_description'); ?></h2>
            </div>
            <div class="card-body">
                <h4 class="mt-2"><?php echo $this->lang->line('general_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                            <td><?php echo $location['dist']; ?></td>
                            <td><?php echo $location['sub']; ?></td>
                            <td><?php echo $location['cir']; ?></td>
                            <td><?php echo $location['lot']; ?></td>
                            <td><?php echo $location['mouza']; ?></td>
                            <td><?php echo $location['vill']; ?></td>
                            <td><?php echo $conv_type; ?></td>
                            <td><?php echo $location['add_to']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($location['date'])); ?></td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="mt-4"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><label><?php echo $this->lang->line('dag_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                            <th><label><?php echo $this->lang->line('patta_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('patta_type'); ?></label></th>
                            <th><label><?php echo $this->lang->line('show_chitha'); ?></label></th>
                            <th><label><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $land_details['dag']; ?></td>
                            <td><?php echo $land_details['m_dag_area_b'] . " বিঘা " . $land_details['m_dag_area_k'] . " কঠা " . $land_details['m_dag_area_lc'] . " লেছা " ?></td>
                            <td><?php echo $land_details['patta_no']; ?></td>
                            <td><?php echo $patta_type; ?></td>
                            <td><a class="btn btn-primary" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank">চিঠা চাওক</a></td>
                            <td><a class="btn btn-primary" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank">জমাবন্দী চাওক</a></td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="mt-4"><?php echo $this->lang->line('applicant_information'); ?></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><label><?php echo $this->lang->line('sl_no'); ?></label></th>
                            <th><label><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                            <th><label><?php echo $this->lang->line('guardian_name'); ?></label></th>
                            <th><label><?php echo $this->lang->line('relation'); ?></label></th>
                            <th><label><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                            <th><label>AADHAAR/PAN Status</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                $count = 1;
                                foreach ($pattadar as $p):
                                    $flag = 'N/A';
                                    if($p->auth_type == 'AADHAAR'){
                                        $flag = 'AADHAAR Verified';
                                    }else if($p->auth_type == 'PAN'){
                                        $flag = 'PAN Verified';
                                    }
                                    $pdar_name = $p->pdar_name;
                                    $relation = 'f';
                                    $relationship = $this->utilityclass->get_relation($relation);
                                
                                ?>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $pdar_name; ?></td>
                                <td><?php echo $p->pdar_guardian; ?></td>
                                <td><?php echo $relationship; ?></td>
                                <td><?php echo $p->pdar_add1 . " " . $p->pdar_add2; ?></td>
                                <td><?php echo $flag; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

