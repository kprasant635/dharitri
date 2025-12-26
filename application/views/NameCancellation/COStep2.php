<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
            <?php
            $buttonEnabledFlag =1;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                include 'application/views/common/input_hidden_fields_and_func.php';
            }
            ?>
             
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center">CO's Order for Name Cancellation </h2>
                </div>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-10 col-lg-offset-1">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no = $_GET['misc_case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCancellation/COStep2_save"; ?>">  
                            <?php if(ESCALATION_ENABLE == 1){ ?>
                                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <?php 
                                  include(APPPATH."views/escalation/remaining_time.php");
                                ?>
                            <?php } ?>
							
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>

                            <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>                    
                            <input type="hidden" name="misc_case_no" value="<?php echo $misc_case_no; ?>"/> 
							<input type="hidden" name="misc_case_petition_no" value="<?php echo $miscCaseInfo->misc_case_petition_no; ?>"/>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table" width="100%">
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?>  : <strong><?php
                                                        $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d));
                                                        ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            <td class="text-center "><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $user_name->username; ?></strong></h6></td>
                                        </tr>                      
                                    </table>

                                </div>
                            </div>
                            <hr/>
                            <div class="col-lg-6">
                                <h2><mark>First Party information</mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                        <?php
                                        $c = 1;
                                       //foreach ($Petitioner AS $pet) {
                                            ?>
                                            <tr class="success">
                                                <td>
                                                   <?php echo $this->lang->line('petitioner_name');?> : <strong><?php echo $Petitioner->petition_pdar_name_old;?></strong>
                                                </td>
                                            </tr>
                                            
                                            <?php //$c++; } ?>
                                    </table>
                                </div>
                                <div>
                                    <?php include 'application/views/common/aadhar_details_dhar_end_half.php'; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h2><mark>Second Party information</mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                        <?php  foreach ($secondparty AS $ss){ ?>
                                            <tr class="success">
                                                <td>
                                                   <?php echo $this->lang->line('petitioner_name');?> : <strong><?php echo $ss->pdar_name;?></strong>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                            <br/>
                            <!-- /////////ESCALATION REMARK///////////// -->
                          <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $miscCaseInfo->es_flag == 1) { ?>
                            <div class="col-lg-12">
                                <div class="form-group col-md-4 text-right">
                                    <label> Cause For the case has not been pass in the timeline : </label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                </div>
                            </div>
                          <?php } ?>
                          <!---#START PLB--->
                            <?php
                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <div class="col-lg-12">
                                <p class='uni_text'>আবেদনকাৰীৰ আবেদন চোৱা হল । আবেদনকাৰীয়ে <?php echo $namedata[0]->district; ?> জেলার <?php echo $namedata[3]->mouza; ?> মৌজার <?php echo $namedata[5]->village; ?> গ্রামর <?php echo $miscCaseInfo->patta_no;?> নং <?php echo $pattaType->patta_type; ?> পট্টাৰ <?php echo $miscCaseInfo->dag_no;?> নং দাগৰ পৰা দ্বিতীয় পক্ষৰ নাম কৰ্ত্তন বিচাৰিছে । 
                                    আবেদনটি নিবন্ধিত হয়েছে। । সিন্থেটিক লট জোন রিপোর্ট করবে এবং সহকারী দ্বিতীয় পক্ষকে নোটিশ জারি করবে । </p>
                                    <input type="text" class="col-lg-2" value="<?php echo date('d-m-Y'); ?>" name="next_date_of_hearing" readonly="readonly" required id="popupDatepicker"/>
                                   <input type="time" class="col-lg-2" name="next_date_time" value="10:30">
                                    <p class="uni_text">শুনানি ও আপত্তি দাখিলের জন্য তারিখ নির্ধারণ করা হয়েছে ।</p>                            
                            </div>

                            <?php }else{?>
                            <div class="col-lg-12">
                                <p class='uni_text'>আবেদনকাৰীৰ আবেদন চোৱা হল । আবেদনকাৰীয়ে <?php echo $namedata[0]->district; ?> জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $miscCaseInfo->patta_no;?> নং <?php echo $pattaType->patta_type; ?> পট্টাৰ <?php echo $miscCaseInfo->dag_no;?> নং দাগৰ পৰা দ্বিতীয় পক্ষৰ নাম কৰ্ত্তন বিচাৰিছে । 
                                    আবেদনখন পঞ্জীভুক্ত গোচৰ ৰুজু কৰা হল । সংশ্লিস্ট লট মণ্ডলে প্রতিবেদন দিব আৰু সহায়কে দ্বিতীয় পক্ষলৈ জাননী জাৰি কৰিব । </p>
                                    <input type="text" class="col-lg-2" value="<?php echo date('d-m-Y'); ?>" name="next_date_of_hearing" readonly="readonly" required id="popupDatepicker"/>
                                   <input type="time" class="col-lg-2" name="next_date_time" value="10:30">
                                    <p class="uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হল ।</p>                            
                            </div>
                            <?php }?>

                            <!--#END PLB-->
                            
                            <input type="hidden" name="p1" value="আবেদনকাৰীৰ আবেদন চোৱা হল । আবেদনকাৰীয়ে <?php echo $namedata[0]->district; ?> জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $miscCaseInfo->patta_no;?> নং <?php echo $pattaType->patta_type; ?> পট্টাৰ নাম কৰ্ত্তন বিচাৰিছে । আবেদনখন পঞ্জীভুক্ত গোচৰ ৰুজু কৰা হল । সংশ্লিস্ট লট মণ্ডলে প্রতিবেদন দিব আৰু সহায়কে দ্বিতীয় পক্ষলৈ জাননী জাৰি কৰিব ।"/>
                            <input type="hidden" name="p2" value="তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হল ।"/>
                            <hr>


                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                            ?>
                        <hr> 
                        <?php if(!empty($app->basundhara)){ ?>

                        <center>
                        <?php if($buttonEnabledFlag==1){?>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                        <?php }?>
                         <button type="button" id="reject" class="btn btn-danger btn-sm uni_text" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CANCEL?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      

                            <?php }

                             else { ?>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/ViewNCorrPetition"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
									<!-- <a href="<?php //echo base_url() . "index.php/NameCancellation/RejectOrder"; ?>?misc_case_no=<?php //echo $_GET['misc_case_no']; ?>" class="btn btn-info">
                                        <i class='fa fa-check'></i>Reject Order
                                    </a> -->
                                    
                                    <button type="button" id="reject" class="btn btn-danger btn-sm uni_text" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CANCEL?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                    <!-- <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button> -->
                                    <br><br>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                    <i class="fa fa-check-circle"></i>&nbsp; <?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            <?php }?>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php //echo base_url() ?>index.php/NameCancellation/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="">
              <input type="hidden" class="form-control" name='misc_case_no' value="<?php //echo $misc_case_no; ?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
            <div class="modal-body">
                <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('query_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
                <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>

<script>

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>

</script>
<!-- text edited 30-05-2022 -->