<div class='container-fluid'>
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
                            <?php echo $p->pet_name;?></br><hr>
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
                        <?php    endforeach?>
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
                <tr>
                    <td><?php echo $this->lang->line('lm_remark');?></td>
                    <td colspan="10">
                        <?php foreach($dag as $d):?>
                            <?php echo $d->remark; ?>
                        <?php endforeach;?>
                    </td>
                </tr>
               
            </table>
        </div>
    </div>
</div>



<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
           
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('lm_report')?>(<?php echo $this->lang->line('case_no')?> -<?php echo $case_no;?>)</p>
                    </div>
                </div>
                
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                        <tr>
                            <th class='alert-new center'><?php echo $this->lang->line('lm_report')?></th>
                            <th class='alert-new center'><?php echo $this->lang->line('dispute')?></th>
                        </tr>
                        <tr>
                            <td>
                                 <?php echo $note->report_on_possession;?>
                             </td>
                             <td>
                                <?php 
                                    if($note->dispute){
                                      echo $this->lang->line('yes');
                                    }
                                    else{
                                           echo $this->lang->line('no');
                                    }
                                ?>
                             </td>
                        </tr>
                    </table>
                    <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                        <thead>
                            <tr>
                                <th class='alert-new'></th>
                               
                                <th class='alert-new center'><?php echo $this->lang->line('bigha')?></th>
                                <th class='alert-new center'><?php echo $this->lang->line('katha')?></th>
                                <th class='alert-new center'><?php echo $this->lang->line('lesa')?></th>
                                <th class='alert-new center'>Ganda</th>
                                <th class='alert-new center'>Krantik</th>
                                
                               
                            </tr>
                        </thead>
                        <tr>
                            <td><?php echo $this->lang->line('dag_area_for_mutation')?></td>
                             <td>
                                 <?php echo $dag->m_dag_area_b;?>
                             </td>
                             <td>
                                 <?php echo $dag->m_dag_area_k;?>
                             </td>    
                             <td>
                                 <?php echo $dag->m_dag_area_lc;?>
                             </td>
                             <td>
                                 <?php echo $dag->m_dag_area_g;?>
                             </td>    
                             <td>
                                 <?php echo $dag->m_dag_area_kr;?> 
                             </td>
                        </tr>         
                        <tr>         
                             <td><?php echo $this->lang->line('total_dag_area')?></td>
                            <td><?php echo $dag->dag_area_b;?></td>
                            <td><?php echo $dag->dag_area_k;?></td>
                            <td><?php echo $dag->dag_area_lc;?></td>
                            <td><?php echo $dag->dag_area_g;?></td>
                            <td><?php echo $dag->dag_area_kr;?> </td>
                        </tr>
                    </table>
                        <div class="col-lg-12">
                        <center><a target="__blank" href='<?php echo base_url();?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no;?>' class="btn btn-danger">View Chitha</a>
                        <!--<a id='vp' href='<?php echo base_url();?>index.php/officemutation/viewPetition?case_no=<?php echo $case_no;?>' href='#' class="btn btn-danger">View Peition</a> -->
						
                        </center></div>
                </div>
            </div>
        </div>
    </div>
</div>