<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 panel-form col-lg-offset-1" style="padding: 10px">
            <div class="btn btn-info uni_text" id="backMain"><i class="fa fa-reply "></i> &nbsp; <?php echo $this->lang->line('previous_menu'); ?></div>
            <div class="btn btn-warning uni_text" data-toggle="modal" data-target="#myModalLM"><i class="fa fa-share "></i> &nbsp; <?php echo $this->lang->line('see_mondal_rpt'); ?></div>
            <div class="btn btn-primary uni_text" data-toggle="modal" data-target="#myModalApplicant"><i class="fa fa-book "></i> &nbsp; <?php echo $this->lang->line('see_application_rpt'); ?></div>
			<?php 
			//$maplink=MapLink;
			$d=$this->session->userdata('dist_code');	
			$s=$this->session->userdata('subdiv_code');	
			$c=$this->session->userdata('cir_code');	
			$m=$dag_no->mouza_pargona_code;	
			$l=$dag_no->lot_no;	
			$v=$dag_no->vill_townprt_code;	
			$dag=$dag_no->dag_no;	
			$giscode=$d."_".$s."_".$c."_".$m."_".$l."_".$v."&plotno=".$dag;
			if($d=='16' or $d=='06'){
			?><div class="btn btn-info hide uni_text" >
				<a target='_blank' href="http://10.177.2.27:8080/bhunaksha/PlotImage?state=18&giscode=<?=$giscode;?>" style="color: #fff" ><i class="fa fa-map-marker"></i>&nbsp;Show Trace Map</a>
			</div>
			<?php } ?>
            <h2 class="text-center"><?php echo $this->lang->line('partition_skReport'); ?>  ( <?php echo $this->lang->line('case_no');?> <?php echo $this->session->userdata('case_no');?>   )  </h2>
            <?php
                    if($this->session->flashdata('message')){
                  ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>
            <hr>
            <?php //print_r($dag_no); ?>
            <form class="form-horizontal unicode" method="POST" action="<?php echo base_url()?>index.php/partition/SaveSKData">
                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                <div class="form-group">
                  <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('dag_no');?> </label>
                  <div class="col-sm-3">
                      <input class="form-control" name="dag_no" value="<?php echo $dag_no->dag_no; ?>" type="text" readonly="" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('comment');?></label>
                  <?php  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ ?>
                  <div class="col-sm-6">
                      <textarea class="form-control" name="sk_comment" rows="5">লট আমিনের প্রতিবেদন দেখা হইল | সব তথ্য সঠিক |বাটোয়ারা করা যাবে |       
                      </textarea>
                  </div>
              <?php }else{?>

                  <div class="col-sm-6">
                      <textarea class="form-control" name="sk_comment" rows="5">লট মন্ডল ৰ প্রতিবেদন পৰ্য্যবেক্ষণ কৰা হল | সকলো তথ্য সঠিক আছে |বাটোবাৰা কৰিব পাৰে, মোৰ (কানন গোহৰ) সন্মতি আছে |       
                      </textarea>
                  </div>
              <?php }?>
                </div>
                        
                        <?php
                            if($attachment){
                            echo '<h2 class="red">Other Attachments</h2>';
                            
                            foreach ($attachment  as $attachment):
                            //var_dump($attachment);
                            ?>
                            <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $pb->application_ref_no .'&type='. 2 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                            <?php 
                            endforeach; 
                            }
                        ?>

                        <?php
                            if($basundharaAttachment){
                            echo '<h2 class="red">Other Attachments</h2>';
                            foreach ($basundharaAttachment  as $attachment):
                            ?>
                            <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                            <?php 
                            endforeach; 
                            }
                        ?>
                            <?php if($basuCase){ ?>
                            <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                            <?php } ?>
                            <?php
                             if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                    echo "<br>";
                                    echo "<a target='download' href='".base_url() ."index.php/basundhara/document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                <button type="submit" class="btn btn-primary col-lg-offset-4 uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('report_submit');?></button> 
               
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
        document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home";
    };
</script>
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
                        <fieldset><legend><?php echo $this->lang->line('partion_applicant_dtls');?></legend>
                            <table class="table_border">
                                 <tr>
                                    <td><?php echo $this->lang->line('district'); ?>  : <?php echo $location['dist']; ?> </td>
                                    <td> <?php echo $this->lang->line('subdivision'); ?>  : <?php echo $location['sub']; ?></td>
                                    <td> <?php echo $this->lang->line('circle'); ?>  : <?php echo $location['cir']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('mouza'); ?>    : <?php echo $location['mouza']; ?></td>
                                    <td> <?php echo $this->lang->line('lot_no'); ?>   : <?php echo $location['lot']; ?></td>
                                    <td><?php echo $this->lang->line('vill_town'); ?>   :<?php echo $location['vill']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('date_applied'); ?>: <?php
                                        echo date('d-m-Y', strtotime($pb->submission_date));
                                        //echo "$date";
                                        ?></td><td><?php echo $this->lang->line('type')?> : বাটোৱাৰা 
                                        <?php
                                        if ($pb->complete_partition_yn == 'Y') {
                                            echo "( সম্পূৰ্ণ )";
                                        } else {
                                            echo "( অসম্পূৰ্ণ  )";
                                        }
                                        ?> </td>
                                    <td> <?php echo $this->lang->line('user_designation');?> : চক্র বিষয়া</td>
                                </tr>

                            </table>  

                        </fieldset>
                    </div>
                    <?php 
                        if(ESCALATION_ENABLE ==1){
                            include(APPPATH."views/correction/aadhaarInfo.php"); 
                        }                                    
                    ?>
                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dag_dtls');?> </legend>
                            <table class="table table-bordered">
                                <tr>
                                    <th><?php echo $this->lang->line('dag_no');?></th><th><?php echo $this->lang->line('applicant_portion');?> (B - K - L)</th>
                                    <th><?php echo $this->lang->line('revenue');?>  (Rs/-) </th><th><?php echo $this->lang->line('patta_no')?> </th>
                                    <th><?php echo $this->lang->line('patta_type');?>  </th>
                                </tr>
                                <tr class="text-center">
                                <?php foreach ($dags as $d): ?>
                                        <td><?php echo $d->dag_no; ?></td><td> <?php echo $d->m_dag_area_b; ?>-<?php echo $d->m_dag_area_k; ?>-<?php echo $d->m_dag_area_lc; ?> </td>
                                        <td><?php echo number_format($d->revenue,2); ?></td><td><?php echo $d->patta_no; ?></td>
                                        <td><?php
                                            $patta_type = $d->patta_type_code;
                                            echo $this->utilityclass->getPattaName($patta_type);
                                            ?></td>
                                <?php endforeach; ?>
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
                                    <p class="uni_text">(<?php echo $count++; ?>) <?php echo $this->lang->line('applicant_name')?>   : <?php echo $p->pdar_name; ?></p>
                                    <table class="table_border unicode " >
                                        <tr><td><?php echo $this->lang->line('guardian_name'); ?> : <?php echo $p->pdar_guardian; ?></td><td><?php echo $this->lang->line('relation')?>  : <?php  echo $this->utilityclass->get_relation($p->pdar_rel_guar); ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('address1')?> : <?php echo $p->pdar_add1; ?> </td><td><?php echo $this->lang->line('address2')?> : <?php echo $p->pdar_add2; ?></td></tr>
                                        <tr><td class='hide'><?php echo $this->lang->line('remaing_land_exist_not')?>  ::
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


<div class="modal fade" id="myModalLM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('mondal_report')?> (<?php echo $this->lang->line('case_no'); ?> <?php echo $this->session->userdata('case_no') ?>)</h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <hr>
                    <?php                                                            
                    foreach ($lmNote as $lmNote)
                    {
                    ?>
                    <p class="uni_text text-danger badge badge-info">Order Serial No : <?php echo $lmNote->note_no+1; ?></p>
                    <form class="form-horizontal unicode" >
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('mutation_is_not')?></label>
                            <div class="col-sm-3">
                                <?php
                                        if($lmNote->mutation_yn=='Y')
                                        {
                                            $mutation_yn="আছে";
                                        }else{
                                            $mutation_yn="নাই";
                                        }
                                ?>
                                <input type="text" readonly="" value="<?php echo $mutation_yn; ?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('mutation_year')?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" readonly="" value="<?php echo $lmNote->mutation_year; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_how')?></label>
                            <div class="col-sm-3">
                               
                                <input type="text" class="form-control" readonly="" value="<?php echo $this->utilityclass->getTransferType($lmNote->trans_code); ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_other_case')?></label>
                            <div class="col-sm-3">
                                <?php
                                        if($lmNote->other_cases_yn=='Y')
                                        {
                                            $other_cases_yn="আছে";
                                        }else{
                                            $other_cases_yn="নাই";
                                        }
                                ?>
                                <input type="text" name="other_cases_yn" readonly="" class="form-control" value="<?php echo $other_cases_yn; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_revenue_year')?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" readonly="" value="<?php echo $lmNote->revenue_paid_year; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('consent_yes_no')?></label>
                            <div class="col-sm-3">
                                <?php
                                        if($lmNote->copdar_complain_yn =='Y')
                                        {
                                            $copdar_complain_yn="আছে";
                                        }else{
                                            $copdar_complain_yn="নাই";
                                        }
                                ?>
                                <input type="text" class="form-control" readonly="" value="<?php echo $copdar_complain_yn; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('trace_map_show')?></label>
                            <div class="col-sm-3">
                                <?php
                                        if($lmNote->trace_map_yn =='Y')
                                        {
                                            $trace_map_yn="আছে";
                                        }else{
                                            $trace_map_yn="নাই";
                                        }
                                ?>
                                <input type="text" name="trace_map_yn" class="form-control" readonly="" value="<?php echo $trace_map_yn; ?>">
                            </div>
                        </div>          
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('tracemap_byayprak')?>  </label>
                            <div class="col-sm-3">
                                <?php
                                        if($lmNote->ror_byayprak_yn =='Y')
                                        {
                                            $ror_byayprak_yn="আছে";
                                        }else{
                                            $ror_byayprak_yn="নাই";
                                        }
                                ?>
                                <input type="text" name="ror_byayprak_yn" class="form-control" readonly="" value="<?php echo $ror_byayprak_yn; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('short_notes')?></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="lm_note" rows="3"><?php echo $lmNote->partition_info; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('min_revenue')?> </label>
                            <div class="col-sm-3">
                                <input type="text" readonly="" class="form-control" name="min_revenue" value="<?php echo number_format($lmNote->min_revenue,2) ; ?>" >
                            </div>
                        </div>
                      <hr>
                     <div class="col-lg-12" >
                         <?php   
                         $lmname=$this->utilityclass->getDefinedMondalsName($lmNote->dist_code,$lmNote->subdiv_code,$lmNote->cir_code,$lmNote->mouza_pargona_code,$lmNote->lot_no,$lmNote->lm_code);
                         echo "<p class='pull-right uni_text green'>$lmname->lm_name</p>";
                         //var_dump($lmname);
                         ?>
                         <br><br><br>
                         <p class="pull-right uni_text"><?php echo $this->lang->line('lm_sign');?></p>
                     </div>
                     <div class="col-lg-12" >
                         <span class="uni_text "> <?php echo $this->lang->line('lm_sign_date');?> : <?php echo date('d/m/Y',  strtotime($lmNote->lm_sign_date)); ?> </span>
                         
                     </div>
                    </form>
                    <hr  style=" border:2px solid #000; width: 100%">
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
            <?php
                    if($this->session->flashdata('query_mdl_message')){
                  ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('query_mdl_message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<script>
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
</script>

<style type="text/css">
.h-divider{

}
</style>