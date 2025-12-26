<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 center-col">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="bold" style="text-align: center;"><?php  echo $this->lang->line('case_no'); ?>: <?php echo $case_no;?></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('general_information'); ?></p>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th class='alert-new'><?php  echo $this->lang->line('district'); ?>:<?php echo $location['dist']; ?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('subdivision'); ?>:<?php echo $location['sub']; ?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('circle'); ?>:<?php echo $location['cir']; ?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('lot_no'); ?>:<?php echo $location['lot']; ?></th>
                                    </tr>
                                </thead>
                                
                                <tr>
                                    <td><?php  echo $this->lang->line('mouza'); ?>:<?php echo $location['mouza']; ?></td>
                                    <td><?php  echo $this->lang->line('vill_town'); ?>:<?php echo $location['vill']; ?></td>
                                    <td><?php  echo $this->lang->line('transfer_type'); ?>:<?php
                                    if($tranfer_type != false){

                                     echo $tranfer_type; 
                                    
                                    }else{
                                        echo "Select transfer type before selection of hearing date";
                                    }

                                ?></td>
                                    <td><?php  echo $this->lang->line('address_to'); ?>:<?php echo $addressed_to->username; ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                   <hr>
                   <?php include(APPPATH."views/correction/aadhaarInfo.php"); ?>
                   
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('applicant_information')?></p>
                            
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th class='alert-new'><?php  echo $this->lang->line('applicant_id')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('applicants_name')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('guardian_name')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('relation')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('address1')?>/<?php  echo $this->lang->line('address2')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('date_applied')?></th>
                                        <th class='alert-new'>Mobile</th>
                                        <th>Aadhaar/PAN Status</th>
                                    </tr>
                                </thead>
                                <?php $count = 1; ?>

                                <?php foreach ($petitioner as $p):

                                            if($p['auth_type'] !=null){
                                                $status = $p['auth_type']. " Verified";
                                                $engName = $p['pdar_name_eng'];
                                                // $base64_decoded_adhar_file = $base64_decoded_adhar_file;
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                                // $base64_decoded_adhar_file = null;
                                            }

                                             ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $p['pet_name']; ?></td>
                                        <td><?php echo $p['guard_name']; ?></td>
                                        <td><?php echo $this->utilityclass->get_relation($p['guard_rel']); ?></td>
                                        <td><?php echo $p['add1'] . "/" . $p['add2']; ?></td>
                                        <td><?php echo date('d-m-y',  strtotime($p['date_entry'])); ?></td>
                                        <td><b class="uni_text text-success"><?=$p['pdar_mobile']?"(".$p['pdar_mobile'].")":null?></b></td>

                                        <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('application_dag_details_information')?></p>
                           
                            <table class="table table-striped">
                                <thead>
                                <th class='alert-new'><?php  echo $this->lang->line('dag_no')?></th>
                                <?php
                                  $dist_code = $this->session->userdata('dist_code');
                                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <th class='alert-new'><?php  echo $this->lang->line('land_area_mutation')?><br>B-K-C-G</th>
                            <?php }else{?>
                                <th class='alert-new'><?php  echo $this->lang->line('land_area_mutation')?><br><?php  echo $this->lang->line('B-K-L')?></th>
                            <?php }?>
                                <th class='alert-new'><?php  echo $this->lang->line('patta_no')?></th>
                                <th class='alert-new'><?php  echo $this->lang->line('patta_type')?></th>
                                </thead>
                                <?php foreach ($dags as $d): ?>
                                    <tr>
                                        
                                        <td>Dag No: <?php echo $d['dag_no']; ?></td>
                                <?php
                                  $dist_code = $this->session->userdata('dist_code');
                                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                        <td>
                                            <?php echo $d['m_dag_area_b']."-".$d['m_dag_area_k']."-".$d['m_dag_area_lc']."-".$d['m_dag_area_g']; ?>
                                        </td>
                                     <?php }else{?>   
                                        <td>
                                            <?php echo $d['m_dag_area_b']."-".$d['m_dag_area_k']."-".$d['m_dag_area_lc']; ?>
                                        </td>
                                    <?php }?>
                                        <td><?php echo $d['patta_no'];?>
                                        <td><?php echo $this->utilityclass->getPattaType($d['patta_type_code']);?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>Deed No: <?=$pb->deed_no;?></td>
                                    <td>Deed Date: <?=$pb->deed_date;?></td>
                                    <td>Deed Value: <?=$pb->deed_value;?></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
<!--                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular">Second Party Information</p>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Applicant ID</th>
                                        <th>Second Party</th>
                                        <th>Guardian Name</th>
                                        <th>Realtion</th>
                                        <th>Address1/Address2</th>
                                    </tr>
                                </thead>
                                <?php $count = 1; ?>
                                <?php foreach ($pattadar as $p): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $p['pdar_name']; ?></td>
                                        <td><?php echo $p['pdar_guardian']; ?></td>
                                        <td><?php echo $p['pdar_rel_guar']; ?></td>
                                        <td><?php echo $p['pdar_add1'] . "/" . $p['pdar_add2']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </table>

                        </div>
                    </div>-->
                  
                </div>
            </div>
        </div>
    </div>
</div>