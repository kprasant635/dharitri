<!-- <div class='container-fluid'> -->
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
            <table class="table table-bordered" style='overflow:auto;'>
                <tr>
                    <td class="center red"><?php echo $this->lang->line('district');?> : <?php echo $location['d']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('subdivision');?> : <?php echo $location['sd']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('circle');?> : <?php echo $location['c']; ?></td>
                </tr>
                <tr>
                    <td class="center red"><?php echo $this->lang->line('mouza');?> : <?php echo $location['m']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('lot_no');?> : <?php echo $location['l']; ?></td>
                    <td class="center red"><?php echo $this->lang->line('vill_town');?> : <?php echo $location['v']; ?></td>
                </tr>
            </table>
            <div class="row">
                <div class="col-lg-12">
                    <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                    <label class="col-sm-4 rasid">&nbsp;</label>
                    <label class="col-sm-4 rasid"><?php echo $this->lang->line('report_date');?> : <?php echo date('d-m-Y',strtotime($pattadar->report_date)); ?></label>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr >
                        <th><?php echo $this->lang->line('name_of_the_applicants_with_address');?></th>
                        <th><?php echo $this->lang->line('dag_no');?>/Patta No<br><hr><?php echo $this->lang->line('total_dag_area');?></th>
                        <th>Area in which mutation/partition applicable</th>
                        <th><?php echo $this->lang->line('name_of_the_pattadar(s)_in_the_said_plot');?></th>
                        <th><?php echo $this->lang->line('area_left_in_the_name_of_pattadar(s)');?></th>
                        <th><?php echo $this->lang->line('by_way_of');?> </th>
                        <th><?php echo $this->lang->line('registration_deed_no(if any)');?></th>
                        <th><?php echo $this->lang->line('possession');?></th>
                        <th><?php echo $this->lang->line('dispute');?></th>
                        <th><?php echo $this->lang->line('land_valuation');?></th>
                    </tr>
                </thead>
                <tr>
                    <td>
                        <?php foreach($petitioner as $p):?>
                            <?php echo $p->pet_name;?><b class="uni_text text-success"><?=$p->pdar_mobile?"(".$p->pdar_mobile.")":null?></b></br><hr>
                        <?php endforeach;?>
                    </td>
                    <td> 
                        <?php foreach($dag as $d):?>
                        <?php echo $d->dag_no."/".$d->patta_no."<br>";?>
                        <?php echo $d->dag_area_b."-".$d->dag_area_k."-".$d->dag_area_lc;?>
                        <hr>
                        <?php endforeach;?>
                    </td>
                     <td> 
                        <?php foreach($dag as $d):?>
                            <?php echo $d->m_dag_area_b."-".$d->m_dag_area_k."-".$d->m_dag_area_lc;?>
                         <hr>
                        <?php endforeach;?>
                    </td>
                    <td>
                        <?php foreach($allpattadar as $dags):?>
                        <?php $count=1;foreach($dags as $p):?>
                        
                            <?php echo $count++.") ".$p->pdar_name."<br>";?>
                        <?php endforeach;?>
                        <?php   echo "<hr>"; endforeach?>
                    </td>
                    <td>
                            
                            <?php foreach ($land_rem as $r):?>
                                
                                    <?php echo $r['rem_b']."-".$r['rem_k']."-".$r['rem_lc'];?> 
                                    <hr>
                            <?php endforeach;?>
                       
                    
                    </td>
                    <td><?php echo $location['trans_code']; ?></td>
                    <td><?php echo $location['deedno']; ?></td>
                    <td><?php  if($location['possession']=='y') echo "Yes"; else echo "No"; ?></td>
                    <td><?php  if($location['dispute']=='0') echo "No"; else echo "Yes"; ?></td>
                    <td>
                        <?php foreach($dag as $d):?>
                               
                                <?php echo $d->land_valuation; ?>
                            <?php endforeach;;?>
                        
                    </td>
                    
                </tr>
                <!-- <tr>
                    <td><?php echo $this->lang->line('lm_remark');?></td>
                    <td colspan="10">
                        <?php foreach($dag as $d):?>
                            <?php echo $d->remark; ?>
                        <?php endforeach;?>
                    </td>
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
<!-- </div> -->
