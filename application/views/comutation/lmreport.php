<div class='container-fluid login form-top'>
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
            <table class="table" >
                <tr>
                    <td><?php echo $this->lang->line('district');?>:<?php echo $location['d']; ?></td>
                    <td><?php echo $this->lang->line('subdivision');?>:<?php echo $location['sd']; ?></td>
                    <td><?php echo $this->lang->line('circle');?>:<?php echo $location['c']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('mouza');?>:<?php echo $location['d']; ?></td>
                    <td><?php echo $this->lang->line('lot_no');?>:<?php echo $location['l']; ?></td>
                    <td><?php echo $this->lang->line('vill_town');?>:<?php echo $location['v']; ?></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr >
                        <th class='alert-new'><?php echo $this->lang->line('case_no');?><br><hr><?php echo $this->lang->line('report_date');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('name_of_the_applicants_with_address');?> </th>
                        <th class='alert-new'><?php echo $this->lang->line('dag_no');?><br><hr><?php echo $this->lang->line('total_dag_area');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('area_in_which_mutation_is_admissible_in_favor_of_the_applicant(s)');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('name_of_the_pattadar(s)_in_the_said_plot');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('area_left_in_the_name_of_pattadar(s)');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('by_way_of');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('registration_deed_no(if any)');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('possession');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('dispute');?></th>
                        <th class='alert-new'><?php echo $this->lang->line('land_valuation');?></th>
                    </tr>
                </thead>
                <tr>
                    <td><?php echo $case_no; ?><hr><?php echo date('d-m-Y',strtotime($pattadar->report_date)); ?></td>
                    <td>
                        <?php foreach($petitioner as $p):?>
                            <?php echo $p->pet_name;?><b class="uni_text text-success"><?=$p->pdar_mobile?"(".$p->pdar_mobile.")":null?></b></br><hr>
                        <?php endforeach;?>
                    </td>
                    <td> 
                        <?php echo $dag->dag_no;?>
                        <hr>
                        <?php echo $dag->dag_area_b."-".$dag->dag_area_k."-".$dag->dag_area_lc;?>
                    </td>
                     <td> 
                       
                        <?php echo $dag->m_dag_area_b."-".$dag->m_dag_area_k."-".$dag->m_dag_area_lc;?>
                    </td>
                    <td>
                        <?php $count=1;foreach($allpattadar as $p):?>
                            <?php echo $count++.") ".$p->pdar_name."<br>";?>
                        <?php endforeach;?>
                    </td>
                    <td><?php echo $location['c']; ?></td>
                    <td><?php echo $location['trans_code']; ?></td>
                    <td><?php echo $location['deedno']; ?></td>
                    <td><?php echo $location['possession']; ?></td>
                    <td><?php echo $location['dispute']; ?></td>
                    <td><?php echo $dag->land_valuation; ?></td>
                    
                </tr>
                <!-- <tr>
                    <td><?php echo $this->lang->line('lm_remark');?></td>
                    <td colspan="10"><?php echo $dag->remark; ?></td>

                </tr> -->
                <tr>
                  <td><?php echo $this->lang->line('lm_remark');?></td>
                  <td colspan="10">    
                    <?php foreach($lm_remark as $case):?>
                        <p><?php echo $case['date_entry'];?> &#8594; <?php echo $case['remark'];?></p><br>                       
                    <?php endforeach;?>
                  </td>
                </tr>
            </table>
        </div>
    </div>
</div>
