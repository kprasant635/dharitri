<div class="col-lg-12 " style="display: inline-block" >
                    <div class="form_1" >
                        <fieldset><legend><?php echo $this->lang->line('partion_applicant_dtls');?> </legend>
                            <table class="table_border">
                                <tr>
                                    <td><?php echo $this->lang->line('district'); ?>: <?php echo $location['dist']; ?> </td>
                                    <td> <?php echo $this->lang->line('subdivision'); ?>   : <?php echo $location['sub']; ?></td>
                                    <td> <?php echo $this->lang->line('circle'); ?>   : <?php echo $location['cir']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('mouza'); ?>    : <?php echo $location['mouza']; ?></td>
                                    <td> <?php echo $this->lang->line('lot_no'); ?>   : <?php echo $location['lot']; ?></td>
                                    <td><?php echo $this->lang->line('vill_town'); ?> :<?php echo $location['vill']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('date_applied'); ?> : <?php
                                        echo date('d-m-Y', strtotime($pb->submission_date));
                                        //echo "$date";
                                        ?></td><td><?php echo $this->lang->line('type')?>  : বাটোৱাৰা 
                                        <?php
                                        if ($pb->complete_partition_yn == 'Y') {
                                            echo "( সম্পূৰ্ণ   )";
                                        } else {
                                            echo "( অসম্পূৰ্ণ  )";
                                        }
                                        ?> </td>
                                    <td> <?php echo $this->lang->line('user_designation');?>  : চক্র বিষয়া</td>
                                </tr>

                            </table>  

                        </fieldset>
                    </div>
                    <?php include(APPPATH."views/correction/aadhaarInfo.php"); ?>
                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dag_dtls');?>  </legend>
                            <table class="table table-bordered">
                                <tr class="active text-center">
                                    <th class="text-center"><?php echo $this->lang->line('dag_no');?></th><th class="text-center"><?php echo $this->lang->line('applicant_portion');?> (B - K - L)</th>
                                    <th class="text-center"> <?php echo $this->lang->line('revenue');?>   (Rs/-) </th><th class="text-center"><?php echo $this->lang->line('patta_no')?></th>
                                    <th class="text-center"><?php echo $this->lang->line('patta_type');?> </th>
                                </tr>
                                <tr class="text-center">
                                <?php //foreach ($dags as $d): ?>
                                        <td><?php echo $dags->dag_no; ?></td><td> <?php echo $dags->m_dag_area_b; ?>-<?php echo $dags->m_dag_area_k; ?>-<?php echo $dags->m_dag_area_lc; ?> </td>
                                        <td><?php echo number_format($dags->revenue, 2) ; ?></td><td><?php echo $dags->patta_no; ?></td>
                                        <td><?php
                                            $patta_type = $dags->patta_type_code;
                                            echo $this->utilityclass->getPattaName($patta_type);
                                            ?></td>
                                <?php //endforeach; ?>
                                </tr>
                            </table>  
                        </fieldset>
                    </div>

                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dtls');?></legend>
                            <div class="col-lg-12">
                                <?php
                                $count = 1;
                                foreach ($PetiPart as $p):
                                    ?>
                                    <p class="uni_text">(<?php echo $count++; ?>) <?php echo $this->lang->line('applicant_name')?>  : <?php echo $p->pdar_name; ?></p>
                                    <table class="table_border unicode " >
                                        <tr><td><?php echo $this->lang->line('guardian_name'); ?>  : <?php echo $p->pdar_guardian; ?></td><td><?php echo $this->lang->line('relation')?>  : <?php echo $this->utilityclass->get_relation($p->pdar_rel_guar); ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('address1')?> : <?php echo $p->pdar_add1; ?> </td><td><?php echo $this->lang->line('address2')?> : <?php echo $p->pdar_add2; ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('mobile_no')?> : <?php echo $p->pdar_mobile; ?> </td><td><?php echo $this->lang->line('voter_id')?> : <?php echo $p->pdar_citizen_no; ?></td></tr>
                                        <tr class='hide'><td><?php echo $this->lang->line('remaing_land_exist_not')?>  ::
                                            <?php
                                            if($p->is_converted_pattadar=='N')
                                            { echo "নাথাকে"; }
                                            else{ echo "ঠাকিব";}
                                            ?>
                                            </td><td></td></tr>
                                    </table>
                                <?php endforeach; ?>    
                            </div> 
                        </fieldset>
                    </div>
                </div>