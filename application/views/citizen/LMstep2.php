<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form');  ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no'); ?> :<?php echo $data->cert_no; ?> </p></div>
                            <div class="col-lg-5"><p class="uni_text text-center">
                                <?php
                                if($data->application_ref_no){
                                    echo "অনলাইনত উল্লেখ নং : ".$data->application_ref_no;
                                }
                                ?> </p></div>
                                <div class="col-lg-3"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date'); ?> :<?php echo date('d-m-Y', strtotime($data->apply_date)); ?> </p></div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <form class="form-horizontal unicode" >
                                <?php
                                // echo '<pre>';
                                // var_dump($coComment);
                                // die();
                                // $size = sizeof($coComment);
                                $size = !empty($coComment);
                                // if ($size != 0) {
                                if ($size) {
                                    ?>
                                    <h2 class="red"><?php echo $this->lang->line('co_order_to_lm'); ?></h2>
                                    <div class="form-group">
                                        <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('date') ?></label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control " name="vill_name" value="<?php echo date('d/m/Y', strtotime($coComment->comment_date)); ?>" readonly>
                                        </div> 
                                        <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('co_comment'); ?></label>
                                        <div class="col-lg-4">
                                            <textarea class="form-control" rows="5" cols="5" readonly><?php echo $coComment->co_comment; ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?> 
                            </form>

                            <form class="form-horizontal unicode" action="<?php echo base_url('index.php/citizencontroller/LMStep3'); ?>" method="POST" >
                                <!--#START PLB-->
                                <?php if(!empty($app->basundhara)){ ?>
                                    <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                                <?php } ?>
                                <!--#END PLB-->
                                <h2 class="red">Location Details</h2>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control districtselect" id="select" name="dist_code" required> -->
                                        <select class="form-control districtselect" id="select" name="" required>
                                            <option value="<?php echo $data->dist_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($data->dist_code); ?>
                                            </option>
                                        </select>
                                    </div> 
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control subdivselect" id="select" name="subdiv_code" required> -->
                                        <select class="form-control subdivselect" id="select" name="" required>
                                            <option value="<?php echo $data->subdiv_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getSubDivName($data->dist_code, $data->subdiv_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control circleselect" id="select" required name="circle_code"> -->
                                        <select class="form-control circleselect" id="select" required name="">
                                            <option value="<?php echo $data->cir_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getCircleName($data->dist_code, $data->subdiv_code, $data->cir_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control mouzaselect" id="select" required name="mouza_code"> -->
                                        <select class="form-control mouzaselect" id="select" required name="">
                                            <option value="<?php echo $data->mouza_pargona_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getMouzaName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control lotselect" id="select" required name="lot_no"> -->
                                        <select class="form-control lotselect" id="select" required name="">
                                            <option value="<?php echo $data->lot_no; ?>"  selected>
                                                <?php echo $this->utilityclass->getLotName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?> </label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control villageselect" id="select" required name="vill_name"> -->
                                        <select class="form-control villageselect" id="select" required name="">
                                            <option value="<?php echo $data->vill_townprt_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getVillageName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_type'); ?></label>
                                    <div class="col-lg-4">
                                        <!-- <select class="form-control pattatype_nmae"  required name="patta_code"> -->
                                        <select class="form-control pattatype_nmae"  required name="">
                                            <?php $patta_type = $this->utilityclass->getpattaName($data->patta_type_code); ?>?>
                                            <option value="<?php echo $data->patta_type_code; ?>"><?php echo $patta_type; ?></option>
                                        </select>
                                    </div>

                                    <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_no'); ?></label>
                                    <div class="col-lg-4">
                                        <!-- <input type="text" readonly="" class="form-control " name="patta_no" value="<?php //echo $data->patta_no; ?>"> -->
                                        <input type="text" readonly="" class="form-control " name="" value="<?php echo $data->patta_no; ?>">
                                    </div>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <h2 class="red">Applicant Details</h2>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Applicant Name</label>
                                    <div class="col-lg-4">
                                        <!-- <input type="text" name="relation" class="form-control " readonly="" value="<?php //echo $data->appln_name; ?>"> -->
                                        <input type="text" name="" class="form-control " readonly="" value="<?php echo $data->appln_name; ?>">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                    <div class="col-lg-4">
                                        <?php 
                                        $pdar_mobile=$data->pdar_mobile;
                                        if($data->pdar_mobile == '0'){
                                            $pdar_mobile = '';
                                        }
                                        ?>
                                        <!-- <input type="text" name="mobile_no" class="form-control " value="<?php //echo $pdar_mobile; ?>"> -->
                                        <input type="text" name="" class="form-control " value="<?php echo $pdar_mobile; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Gurdian Name</label>
                                    <div class="col-lg-4">
                                        <!-- <input type="text" name="guard_name" class="form-control " readonly="" value="<?php //echo $data->appln_guard; ?>"> -->
                                        <input type="text" name="" class="form-control " readonly="" value="<?php echo $data->appln_guard; ?>">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('relation'); ?></label>
                                    <div class="col-lg-4">
                                        <?php $relation = $this->utilityclass->get_relation($data->guard_reln);?>
                                        <!-- <input type="text" name="relation" class="form-control" readonly="" value="<?php //echo $relation; ?>"  > -->
                                        <input type="text" name="" class="form-control" readonly="" value="<?php echo $relation; ?>"  >
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php //echo $this->lang->line('aadhar_no'); ?></label>
                                    <div class="col-lg-4"> -->
                                        <?php 
                                        // $pdar_aadharno=$data->pdar_aadharno;
                                        // if($data->pdar_aadharno == '0'){
                                        //     $pdar_aadharno = '';
                                        // }
                                        ?>
                                        <!-- <input type="text" name="aadhar_no" class="form-control " value="<?php //echo $pdar_aadharno; ?>"  > -->
                                    <!-- </div>
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php //echo $this->lang->line('pan_no'); ?></label>
                                    <div class="col-lg-4"> -->
                                        <?php 
                                        // $pdar_pan=$data->pdar_pan;
                                        // if($data->pdar_pan == '0'){
                                        //     $pdar_pan = '';
                                        // }
                                        ?>
                                        <!-- <input type="text" name="pan_no" class="form-control " value="<?php //echo $pdar_pan; ?>"  > -->
                                    <!-- </div>
                                </div> -->
                                <hr style="border-bottom: 2px solid #000;">
                                <?php 
                                if($attachment){
                                    foreach ($attachment as $attachment): 
                                        ?>
                                        <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $application_ref_no .'&type='. 3 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                                    <?php endforeach; 
                                }
                                ?>
                                <!--#START PLB-->
                                <?php
                                if($basundharaAttachment){
                                    echo '<h2 class="red">Attachments</h2> <ul>';
                                    foreach ($basundharaAttachment  as $attachment):
                                        ?>
                                        <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                        <?php 
                                    endforeach; 
                                    echo "</ul>";
                                }
                                ?>

                                <?php
                                if(isset($query)){
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
                                            echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                        }
                                        ?></td>
                                    </tr>
                                    
                                <?php } echo "</table>"; } ?>
                                <!--#END PLB-->
                                <?php if ($this->session->flashdata('message')): ?>
                                <?php 
                                    echo '<div class="form-group">
                                            <div class="col-lg-8 col-lg-offset-4">
                                                <p style="color:red;">'.$this->session->flashdata('message').'</p>
                                            </div>
                                        </div>';
                                ?>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-4">
                                        <button type="submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                        <button type="reset" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                        <a href="<?php echo base_url(); ?>index.php/CitizenController/LMStep1" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                        <?php if($app) {?>
                                        <!--#START PLB-->
                                        <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                                        <!--#END PLB-->
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--#START PLB-->
    <div id="myModal1" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Type Your Query</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
                 <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara;?>">
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
<!--#END PLB-->

<script>

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>

</script>
