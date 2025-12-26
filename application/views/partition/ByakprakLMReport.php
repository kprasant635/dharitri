<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-8 panel-form col-lg-offset-2" style="padding: 10px">
            <div class="btn btn-info uni_text" id="backMain"><i class="fa fa-reply "></i> &nbsp; <?php echo $this->lang->line('previous_menu'); ?></div>
            <div class="btn btn-warning uni_text" data-toggle="modal" data-target="#myModalApplicant"><i class="fa fa-book "></i> &nbsp; <?php echo $this->lang->line('see_application_rpt');?></div>
            <h2 class="text-center">ভূমি আৰু ৰাজহ আইনৰ ১১৪ ধাৰা মতে বাটোৱাৰা গোচৰৰ ব্যয় প্রাক্ কলন  </h2>
            <hr>
            <?php //var_dump($pattaDar    ); ?>
            <form class="form-horizontal unicode" method="POST" action="<?php echo base_url(); ?>index.php/partition/SaveLmByayPrak">
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mouza_village_patta');?></label>
                  <div class="col-lg-8">
                      <input type="text" readonly="" class="form-control uni_text input-lg" name="mouza_vill_name" value="<?php echo $location['mouza']." মৌজা ৰ ". $location['vill']." গাঁৱৰ ".$patta->patta_no ." No. ".$pattaName->patta_type; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('pattdar_name_address');?></label>
                  <div class="col-lg-8">
                      <textarea readonly="" class="form-control uni_text" name="pdar_name_add" rows="7"><?php
                        $j=1;
                        foreach($pattaDar as $p)
                        {
                            $i=0;
                           echo "( $j )"."&nbsp". $p[$i]->pdar_name.",".$p[$i]->pdar_father.",".$p[$i]->pdar_add1.",".$p[$i]->pdar_add2.",".$p[$i]->pdar_add3."\n"; 
                           $j++;
                        }
                        ?>
                      </textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('land_revenue');?></label>
                  <div class="col-lg-4">
                      <input type="text" name="revenue" required="" class="form-control" value="<?php echo round($revenue) ; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('land_all_details');?> </label>
                  <div class="col-lg-8">
                      <textarea class="form-control" name="land_details" rows="3">বাটোবাৰা হবলগীয়া মাটিৰ পৰিমাণ <?php echo  $dags->m_dag_area_b." B -".$dags->m_dag_area_k." K -".  round($dags->m_dag_area_lc,2)." L "?></textarea>
                  </div>
                </div>
               <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('applicant_add_land');?> </label>
                  <div class="col-lg-8">
                      <textarea class="form-control" name="pet_name_add_por" rows="3"><?php
                      foreach($PetiPart as $p)
                        {
                          //$i=0;
                           echo $p->pdar_name."\n"; 
                           //var_dump($p);
                        }
                      ?>বাটোবাৰা হবলগীয়া মাটিৰ পৰিমাণ <?php echo  $dags->m_dag_area_b." B -".$dags->m_dag_area_k." K -".  round($dags->m_dag_area_lc,2)." L "?>
                      </textarea>
                  </div>
                </div>               
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('coppattdar_land_portion');?></label>
                  <div class="col-lg-8">
                      <textarea class="form-control" name="por_left_details" rows="3"> <?php
                        foreach($pattaDar as $p)
                        {
                            $i=0;
                           echo $p[$i]->pdar_name.",".$p[$i]->pdar_father.",".$p[$i]->pdar_add1.",".$p[$i]->pdar_add2.",".$p[$i]->pdar_add3."\n"; 
                          
                        }
                        ?>
                      </textarea>
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_partition');?></label>
                  <div class="col-lg-4">
                      <input type="text" name="survey_time" class="form-control" value=" ৩ মাঁহ / 3 month(s)">
                  </div>
                </div>          
                
                
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('total_cost_details');?></label>
                  <div class="col-sm-6">
                      <textarea class="form-control" name="exp_details" rows="3">মুঠ খৰচ </textarea>
                  </div>
                  <div class="col-lg-2">
                      <span class="text-danger uni_text"><?php echo $this->lang->line('total_cost');?> 
                      <input type="text" required maxlength="7" id="quantity" name="exp_details_total" class="form-control" >
                      <span id="errmsg"></span>
                  </div>
                </div>
             
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('cost_from_copattadar');?></label>
                  <div class="col-sm-6">
                      <textarea class="form-control" name="copdar_amt" rows="3">সহ-পট্টাদ্বাৰৰ পৰা পাবলগীয়া খৰচ </textarea>
                  </div>
                  <div class="col-lg-2">
                      <span class="text-danger uni_text"><?php echo $this->lang->line('total_cost');?> </span> 
                      <input type="text" required maxlength="7" name="copdar_amt_total" class="landNumB form-control" >
                        <span class="errmsgB"></span>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_for_revenue_collect');?></label>
                  <div class="col-sm-6">
                      <input type="text" required="" name="exp_deposite_time" class="form-control" value="১ সপ্তাহ / 1 week">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_for_byayprak');?></label>
                  <div class="col-sm-6">
                      <input type="text" required="" name="byayprak_comp_time" class="form-control" value="১ সপ্তাহ / 1 week">
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('short_notes');?></label>
                  <div class="col-lg-8">
                      <textarea class="form-control" name="remarks" rows="3"> ব্যয় প্রাককলনৰ জাননী জাৰীকাৰকৰ দ্ৱাৰা জাৰী কৰা হব ।   </textarea>
                  </div>
                </div>
                <button class="btn btn-primary uni_text col-lg-offset-5" type="submit"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button');?> </button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalApplicant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('case_no');?> : <?php echo $this->session->userdata('case_no') ?></h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <div class="form_1" >
                        <fieldset><legend><?php echo $this->lang->line('partion_applicant_dtls');?> </legend>
                            <table class="table_border">
                                <tr>
                                    <td><?php echo $this->lang->line('district'); ?>  : <?php echo $location['dist']; ?> </td>
                                    <td><?php echo $this->lang->line('subdivision'); ?>  : <?php echo $location['sub']; ?></td>
                                    <td> <?php echo $this->lang->line('circle'); ?> : <?php echo $location['cir']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('mouza'); ?>  : <?php echo $location['mouza']; ?></td>
                                    <td><?php echo $this->lang->line('lot_no'); ?>: <?php echo $location['lot']; ?></td>
                                     <td><?php echo $this->lang->line('vill_town'); ?>  :<?php echo $location['vill']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('date_applied'); ?>: <?php
                                        echo date('d-m-Y', strtotime($data->submission_date));
                                        //echo "$date";
                                        ?></td><td><?php echo $this->lang->line('type')?> : বাটোৱাৰা 
                                        <?php
                                        if ($data->complete_partition_yn == 'Y') {
                                            echo "( সম্পূৰ্ণ   )";
                                        } else {
                                            echo "( অসম্পূৰ্ণ  )";
                                        }
                                        ?> </td>
                                    <td> <?php echo $this->lang->line('user_designation');?> : চক্র বিষয়া</td>
                                </tr>

                            </table>  

                        </fieldset>
                    </div>
                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dag_dtls');?> </legend>
                            <table class="table table-bordered">
                                <tr class="active text-center">
                                    <th class="text-center"><?php echo $this->lang->line('dag_no');?></th><th class="text-center"><?php echo $this->lang->line('applicant_portion');?> (B - K - L)</th>
                                    <th class="text-center"> <?php echo $this->lang->line('revenue');?>   (Rs/-) </th><th class="text-center"><?php echo $this->lang->line('patta_no')?></th>
                                    <th class="text-center"><?php echo $this->lang->line('patta_type');?> </th>
                                </tr>
                                <tr class="text-center">
                                <?php
                                        //var_dump($dags);
                              ?>
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
                                        <tr><td><?php echo $this->lang->line('guardian_name'); ?>  : <?php echo $p->pdar_guardian; ?></td><td><?php echo $this->lang->line('relation')?>  : <?php echo $p->pdar_rel_guar; ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('address1')?> : <?php echo $p->pdar_add1; ?> </td><td><?php echo $this->lang->line('address2')?> : <?php echo $p->pdar_add2; ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('mobile_no')?> : <?php echo $p->pdar_mobile; ?> </td><td><?php echo $this->lang->line('voter_id')?> : <?php echo $p->pdar_citizen_no; ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('remaing_land_exist_not')?>  ::
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home";
    };
</script>