<?php
    ///////////// BARAK VALLEY CODE START HERE ////////////////
    $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
?>
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#abc .modal-content').html(data);
                   //$('#modal1').html(data);
                    $('#abc').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal .modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div class="container-fluid form-top login">
    <div class="row">

        <?php if($this->session->flashdata('message')):?>
            <div class="col-lg-12 ">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                </div>
            </div>
        <?php endif;?>


        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Allotment/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    <a class="btn btn-success uni_text" target='_blank'  href='<?php echo base_url() . 'index.php/Allotment/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                    </a>
                    <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>

                     <?php if(isset($basuCase) and $rtps==null) { ?>
                        <button class="btn btn-info btnAddApplicant uni_text"><i class="fa fa-plus-square"></i>&nbsp;Add New Applicant</button>
                    <?php } ?>
                </div>


                <form class="form-horizontal" method="POST" id="lm_submit" enctype="multipart/form-data">
                <div class='panel-body'>
                <br>
                    <h2 class="text-center" style="top:20px;">Report By Lot Mondal</h2><hr>


                    <?php if(isset($basuCase)) { ?>
                    
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th style="background-color: #136a6f; color: #fff" colspan="6">Applicant Details</th>
                            </thead>
                            <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th>#</th>
                                    <th>Applicant`s Name</th>
                                    <th>Guardian Name</th>
                                    <th>Relation</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="allotment_applicant_list">
                                <?php foreach($applicants as $appl): ?>
                                    <tr>
                                        <td><?=$appl->alotee_id?></td>
                                        <td><?=$appl->alotee_name?></td>
                                        <td><?=$appl->alotee_gurdian?></td>
                                        <td><?=$this->utilityclass->get_relation($appl->alotee_reln)?></td>
                                        <td><?=$this->utilityclass->gender($appl->alotee_gender)?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info btnApplicantEditCO" id="<?=$appl->alotee_id?>, <?=$appl->case_no?>" title="Edit Applicant"><i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    <?php } ?>


                    
                    <h4 class="center hide red "><u>Schedule Of Land Allotted</u></h4>
                    <div class="form-group hide col-lg-offset-2">
                                 <label for="select" class="col-lg-1 col-lg-offset-3 control-label">Circle</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" placeholder="Type Here" value="<?php echo $certificate->case_no; ?>"  required name="case_no" />
                                </div>
                                 <label class="col-lg-1 control-label uni_text">Mouza </label>
                                <div class="col-lg-2">
                                    <input type="text" name='vill_code' required="" placeholder="Type Here" value='<?php echo $certificate->vill_townprt_code; ?>'  class="form-control"  >
                                </div>
                                <label class="col-lg-1 control-label uni_text">Village </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  class="form-control"  >
                                </div>
                    </div>
                    <?php //var_dump($dag_details);?>

                    <div class="form-group">
                        <label class="col-lg-3 control-label uni_text">Dag No </label>
                        <div class="col-lg-3 old_dag_no">
                            <input type="text" required="" placeholder="Dag No." readonly value="<?php echo $dag_details->dag_no;?>"  class="form-control"  >
                        </div>


                        <div class="col-lg-3 changed_dag_no">
                            <select class="form-control new_dag_no" name="dag_list" id='dag_list'>
                            </select>
                            <div id="alert_dag_list"></div>
                            <input type="hidden" value="<?php echo $dag_details->dag_no;?>" 
                            name="oDNo">
                        </div>
                        <?php if(isset($basuCase) and $rtps==null) { ?>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-sm btn-warning uni_text btnDagChange pull-right" title="Click to Change Dag No" id="<?=$_GET['case_no']?>"><i class="fa fa-edit"></i>&nbsp;Change Dag No</button>
                            <button type="button" class="btn btn-sm btn-success uni_text btnDagUnchange pull-right"><i class="fa fa-refresh"></i>&nbsp;Unchange Dag No</button>
                        </div>
                        <?php } ?>
                    </div>
                    <?php 
                        ////////// BARAK VALLEY CODE STARTS HERE ///////////
                        if($barak){
                    ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th style="background-color: #136a6f; color: #fff" colspan="5">Land Area Details</th>
                            </thead>
                            <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th>Description</th>
                                    <th>Bigha</th>
                                    <th>Katha</th>
                                    <th>Chatak</th>
                                    <th>Ganda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Area of the Dag</td>
                                    <td>
                                        <input type="text" readonly class="form-control" value='<?php echo $chithaDagArea->dag_area_b;?>' placeholder='Bigha' name="tot_bigha" id="tot_bigha" required="" >
                                    </td>
                                    <td>
                                        <input type="text" readonly value='<?php echo $chithaDagArea->dag_area_k;?>'  class="form-control" placeholder='Katha' name="tot_katha" id="tot_katha" required="" >
                                    </td>
                                    <td>
                                        <input type="text" readonly value='<?php echo $chithaDagArea->dag_area_lc;?>'  class="form-control" name="tot_lessa" placeholder='Chatak' id="tot_lessa" required="" >
                                    </td>
                                    <td>
                                        <input type="text" readonly value='<?php echo $chithaDagArea->dag_area_g;?>'  class="form-control" name="tot_ganda" placeholder='Ganda' id="tot_ganda" required="" >
                                    </td>
                                </tr>
                                <tr class="changed_alloted_area">
                                    <td>Area Alloted</td>
                                    <td>
                                        <input type="text" class="form-control" id="new_alot_b" 
                                        value='0' placeholder='Bigha' name="new_alot_b">
                                        <div id="alert_new_alot_b"></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="new_alot_k" 
                                        value='0' placeholder='Katha' name="new_alot_k">
                                        <div id="alert_new_alot_k"></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="new_alot_lc" 
                                        value='0' placeholder='Chatak' name="new_alot_lc">
                                        <div id="alert_new_alot_lc"></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="new_alot_g" 
                                        value='0' placeholder='Lessa' name="new_alot_g">
                                        <div id="alert_new_alot_g"></div>
                                    </td>
                                </tr>
                                <tr class="unchanged_alloted_area">
                                    <td>Area Alloted</td>
                                    <td>
                                        <input type="text" readonly  class="form-control" 
                                        value='<?php echo $dag_details->alot_area_b;?>'  
                                        required="" placeholder='Bigha' >
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" 
                                        value='<?php echo $dag_details->alot_area_k;?>'  
                                        placeholder='Katha' required="" >
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" 
                                        value='<?php echo $dag_details->alot_area_lc;?>' 
                                        placeholder='Chatak' required=""  >
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" 
                                        value='<?= (($dag_details->alot_area_g=='')?'0':$dag_details->alot_area_g) ?>' 
                                        placeholder='Ganda' required="" >
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    <?php } else { ?>
                        <div class="form-group">     
                            <label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                            <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly class="form-control" value='<?php echo $chithaDagArea->dag_area_b;?>' placeholder='Bigha' name="tot_bigha" id="tot_bigha" required="" >
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly value='<?php echo $chithaDagArea->dag_area_k;?>'  class="form-control" placeholder='Katha' name="tot_katha" id="tot_katha" required="" >
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly value='<?php echo $chithaDagArea->dag_area_lc;?>'  class="form-control" name="tot_lessa" placeholder='Lessa' id="tot_lessa" required="" >
                            </div>  
                        </div>
                        <div class="form-group changed_alloted_area">
                            <label for="inputEmail" class="col-lg-3  control-label">Area Alloted   </label>
                            <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" id="new_alot_b" 
                                value='0' placeholder='Bigha' name="new_alot_b">
                                <div id="alert_new_alot_b"></div>
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" id="new_alot_k" 
                                value='0' placeholder='Katha' name="new_alot_k">
                                <div id="alert_new_alot_k"></div>
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" id="new_alot_lc" 
                                value='0' placeholder='Lessa' name="new_alot_lc">
                                <div id="alert_new_alot_lc"></div>
                            </div>
                        </div>
                        <div class="form-group unchanged_alloted_area">
                            <label for="inputEmail" class="col-lg-3  control-label red">Area Alloted   </label>
                            <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly  class="form-control" value='<?php echo $dag_details->alot_area_b;?>'  required="" placeholder='Bigha' >
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly class="form-control" value='<?php echo $dag_details->alot_area_k;?>'  placeholder='Katha' required="" >
                            </div>
                            <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                            <div class="col-lg-2">
                                <input type="text" readonly class="form-control" value='<?php echo $dag_details->alot_area_lc;?>' placeholder='Lessa' required=""  >

                            </div>  
                        </div>
                    <?php } ////////// BARAK VALLEY CODE ENDS HERE /////////// ?>

                    <div class="form-group dag_changed_upload_NOC">
                        <label for="inputEmail" class="col-lg-3 required  control-label">Upload <?=NOC?></label>
                        <div class="col-lg-3">
                            <input type='file' name="up_noc" id="up_noc">
                        </div>
                        <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                    </div>


                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether Allotment certificate is checked and found ok ?  </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-7 control-label ">Whether Allotment is a recorded tenant ?  </label>
                        <div class="col-lg-2">
                            <label class="radio-inline">
                                <input type="radio" name="allotte_rec"  value="Y" checked="">
                                <?php echo $this->lang->line('consent_yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="allotte_rec"  value="N" >
                                <?php echo $this->lang->line('consent_no'); ?>
                            </label>
                        </div>   
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-7 control-label ">Whether Applicant is the allottee or legal heir of original allottee ?  </label>
                        <div class="col-lg-5">
                            <label class="radio-inline">
                                <input type="radio" name="original_alotee"  value="Y" checked="">
                                Original Allottee
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="original_alotee"  value="N" >
                                Legal heir of original allottee
                            </label>
                        </div>
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-7 control-label ">Whether under possesion of the applicant ? </label>
                        <div class="col-lg-2">
                            <label class="radio-inline">
                                <input type="radio" name="posession_y"  value="Y" checked="">
                                <?php echo $this->lang->line('consent_yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="posession_y"  value="N" >
                                <?php echo $this->lang->line('consent_no'); ?>
                            </label>
                        </div>   
                    </div>
                    
                    
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-7 control-label ">Period of possesion since </label>
                        <div class="col-lg-2">
                            <input type="text" name="p_year" value="<?php echo date('Y'); ?>" class="form-control " checked="" placeholder='Year'> From which Year
                        </div>   
                    </div>
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 required control-label ">Nature of Land Use </label>
                                <div class="col-lg-3">
                                <select class='form-control required' name='land_use'>
                                    <option value='0'>Select Option</option>
                                    <option value='Resindential'>Resindential</option>      
                                    <option value='Cultivation'>Cultivation</option>        
                                    <option value='Others'>Others</option>      
                                <select>
                                </div>
                    </div>
                    <div class="hide form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether the allotted area applied for PP falls within 3 KM radius of Town </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                    </div>
                    <div class="form-group hide">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether the allotted area applied for PP falls within 10 KM radius of GMC </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="ten_km"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="ten_km"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                    </div>
                    <?php
                        ///////// BARAK VALLEY CODE STARTS HERE ////////////
                        if($barak) {
                    ?>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 required control-label ">Area of Land found under possesion </label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Bigha' 
                                name="p_bigha" value="" >
                                <div id="alert_p_bigha"></div>
                                Bigha
                            </div>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Katha' 
                                name="p_katha" value="" >
                                <div id="alert_p_katha"></div>
                                Katha
                            </div>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Chatak' 
                                name="p_lessa" value="" >
                                <div id="alert_p_lessa"></div>
                                Chatak
                            </div>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Ganda' 
                                name="p_ganda" value="" >
                                <div id="alert_p_ganda"></div>
                                Ganda
                            </div>
                        </div>
                    <?php } else { ?>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-5 required control-label ">Area of Land found under possesion </label>
                        <div class="col-lg-2">
                            <input type="text"  class="form-control" placeholder='Bigha' 
                            name="p_bigha" value="" >
                            <div id="alert_p_bigha"></div>
                            Bigha
                        </div>
                        <div class="col-lg-2">
                            <input type="text"  class="form-control" placeholder='Katha' 
                            name="p_katha" value="" >
                            <div id="alert_p_katha"></div>
                            Katha
                        </div>
                        <div class="col-lg-2">
                            <input type="text"  class="form-control" placeholder='Lessa' 
                            name="p_lessa" value="" >
                            <div id="alert_p_lessa"></div>
                            Lessa
                        </div>     
                    </div>
                <?php }?>
                    
                    <div class="form-group"> 
                        <label for="inputEmail" class="col-lg-9 control-label required"> Check Whether Complete Dag Conversion(Old Dag No. remain same) or Not ? </label>
                        <div class="col-lg-2">
                            <input type="radio" name="optrad" id="convDag" class='uni_text' value='Y' checked> No
                            <input type="radio" name="optrad" id="convDag1" class='uni_text' value='N'> Yes
                        </div>
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                        <div class="col-lg-2">
                            <input type="text"  class="form-control show_dag" placeholder='Dag Number' value='<?php echo $new_dag; ?>' name="new_dag" required="" >
                        </div>
                        <div class="col-lg-3" style="display: none">
                            <input type="text"  class="form-control new_dag"  value='<?php echo $new_dag; ?>'  >
                            <input type="text"  class="form-control new_s_dag"  value='<?php echo $dag_details->dag_no;?>'  >
                        </div>
                        <label for="inputEmail" class="col-lg-3 green control-label ">New Patta Type </label>
                        <div class="col-lg-2">
                            <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case_no'];?>'>
                            <select  class="form-control pattaselect" id="select" required name="new_patta_type">
                            <option selected disabled>Select Patta type</option>
                            <?php foreach ($mutpatta as $np) { ?>
                                <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                            <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-3 red control-label ">New Periodic Patta Proposed </label>
                        <div class="col-lg-2">
                            <input type="text" id='new_patta' class="form-control" placeholder='Patta Number' name="new_patta" required value="" >
                        </div>
                        <label for="inputEmail" class="col-lg-3 green control-label ">New Dag Landclass Code </label>
                        <div class="col-lg-2">
                            <select class="form-control" name="new_landcode">
                                <?php foreach($landsql as $np): ?>
                                <option value='<?=$np->class_code?>'><?=$np->land_type?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">    
                                <label for="inputEmail" class="col-lg-3  control-label ">Check Existing Dag </label>
                                <div class="col-lg-2">
                                    <select class="form-control">
                                        <?php foreach($dag_patta as $d){ ?>
                                        <option><?php echo $d->dag_no; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-4 control-label ">Check Existing Patta</label>
                                <div class="col-lg-2">
                                    <select class="form-control">
                                        <?php foreach($dag_patta as $d){ ?>
                                        <option><?php echo $d->patta_no; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                    </div>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-3 required control-label ">Existing TB Revenue </label>
                        <div class="col-lg-2">
                            <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_revenue" value="" >
                            <div id="alert_exist_revenue"></div>
                        </div>
                        <label for="inputEmail" class="col-lg-4 required control-label ">Existing Local Tax</label>
                        <div class="col-lg-2">
                            <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_local_tax" value="" >
                            <div id="alert_exist_local_tax"></div>
                        </div>
                    </div>
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue" value="" >
                                    <div id="alert_revenue"></div>
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax" value="" >
                                    <div id="alert_local_tax"></div>
                                </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <?php 
                            ////////// BARAK VALLEY CODE STARTS HERE ///////////
                            if($barak){
                        ?>
                            <ul>
                                <li>
                                    <label class="control-label uni_text"> i. কথিত মাটি গ্রামীণ এলাকার মাটি ? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="ru" class="get_premium_asses center">
                                </li>
                                <li>
                                    <label class="control-label"> ii. উল্লিখিত ভূমি রাজস্ব শহর এবং এর প্রান্তিক এলাকা কি জমি ? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="rv" class="get_premium_assessed">
                                </li>
                                <li>
                                    <label class="control-label">  iii. হেড কোয়ার্টার, উত্তর গুয়াহাটি, রঙ্গিয়া এবং পলাশবাড়ি শহর ব্যতীত জেলার উল্লিখিত জমির এলাকা কি? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="hq" class="get_premium_assessed">
                                </li>
                                <li>
                                    <label class="control-label">  iv. অন্য বিকল্পটি এই অবস্থায় নেই &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="ot" class="get_premium_assessed">
                                </li>   
                            </ul>
                        <?php } else { ?>
                        <ul>
                                <li>
                                    <label class="control-label uni_text"> i. উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে ? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="ru" class="get_premium_asses center">
                                </li>
                                <li>
                                    <label class="control-label"> ii. উক্ত মাটি ৰাজহ নগৰ আৰু ইয়াৰ প্ৰান্তীয় এলেকা মাটি হয়নে ? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="rv" class="get_premium_assessed">
                                </li>
                                <li>
                                    <label class="control-label">  iii. উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ পৰিধি অঞ্চল মাটি হয়নে ? &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="hq" class="get_premium_assessed">
                                </li>
                                <li>
                                    <label class="control-label">  iv. আনবিকল্প বিকল্প এই চৰ্তত নাই &nbsp;</label>
                                    <input type="radio" name="whetherOr" id="inlineRadio1" required value="ot" class="get_premium_assessed">
                                </li>   
                        </ul>
                    <?php }?>
                    </div>
                    <hr>
                    <?php if($co_comment){?>

                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-2 required control-label ">CO's Comment </label>
                        <div class="col-lg-10">
                            <textarea class="form-control co_comment" rows="5" 
                            readonly><?php echo $co_comment->co_order;?> </textarea>
                        </div>
                    </div>
                <?php }?>

                    <?php //var_dump($mouzaname);?>
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                        <?php 
                            ////////// BARAK VALLEY CODE STARTS HERE ///////////
                            if($barak){
                        ?>
                            <div class="col-lg-10">
                                <textarea class="form-control lm_comment" rows=10 
                                placeholder='Type here' name="lm_comment" value="">আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  <?php echo $dag_details->dag_no; ?> নং দাগর  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?>  ছাটক <?php echo $dag_details->alot_area_g; ?> গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে। । </textarea>
                                <div id="alert_lm_comment"></div>
                            </div>
                        <?php } else { ?>
                        <div class="col-lg-10">
                            <textarea class="form-control lm_comment" rows=10 
                            placeholder='Type here' name="lm_comment" value="">আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  <?php echo $dag_details->dag_no; ?> নং দাগৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় । </textarea>
                            <div id="alert_lm_comment"></div>
                        </div>
                    <?php }?>

                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail" class="text-red col-lg-4 control-label">Upload Allotment Certificate</label>
                        <div class="col-lg-8">
                            <input type='file' name="upload_allotment" id="upload_allotment">
                        </div>
                        <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                    </div>



                    <?php
                if($basundharaAttachment){
                echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
                foreach ($basundharaAttachment  as $attachment):
                ?>
                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                <?php 

                endforeach; 
                }
                echo "</div>";
                ?>
                <?php if(isset($noc_cert) and !empty($noc_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View NOC (For Changing Dag)</h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$noc_cert->id?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo NOC;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>

                <?php if(isset($allot_cert) and !empty($allot_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View <?=ALLOT_CERT?></h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$allot_cert->id?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo ALLOT_CERT;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                <div id="err_message" class="col-lg-12 text-bold text-red"></div>
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"> <span id="msg1" style="display:none"><div class="alert alert-danger text-center"></div></span>
 </div>
               <div class="panel-footer">
                    
                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                   
                </div>

                <input type="hidden" id="change_dag" name="change_dag" value="0">
                <input type="hidden" id="case" name="case" value="<?=$allotment_cb->case_no?>">
                <input type="hidden" id="dist_code" name="dist_code" value="<?=$cases->dist_code?>">
                <input type="hidden" id="subdiv_code" name="subdiv_code" value="<?=$cases->subdiv_code?>">
                <input type="hidden" id="cir_code" name="cir_code" value="<?=$cases->circle_code?>">
                <input type="hidden" id="mouza_pargona_code" name="mouza_pargona_code" 
                value="<?=$cases->mouza_pargona_code?>">
                <input type="hidden" id="vill_townprt_code" name="vill_townprt_code" value="<?=$cases->vill_townprt_code?>">
                <input type="hidden" id="lot_no" name="lot_no" value="<?=$cases->lot_no?>">
                <input type="hidden" id="old_dag" name="old_dag" value="<?=$dag_details->dag_no?>">
                <input type="hidden" id="patta_type_code" name="type_code" value="">
                
                </form>
                
            </div>
         </div>
        
    </div>
    </div>    
</div>

<div class="modal bs-example-modal-lg" id='abc' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<style type="text/css">
    ::placeholder {
        color:blue;
        font-size: 0.8em;
    }
</style>

<!---// Add New Applicant --->
<div class="modal" id="addNewApplicant_123" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-bold">
                        Add New Applicant for Case No: <span class="text-red "><?=$allotment_cb->case_no?></span>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr></div>

                    <form id="add_new_applicant" method="post">
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Applicant Name</span>
                            <span class="text-red text-bold">*</span>
                            <input type="text" class="form-control" name="appl_name" id="appl_name" value="" placeholder="Enter Applicant">
                            <div id="error_allotment_appl_name"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Guardian Name</span>
                            <span class="text-red text-bold">*</span>
                            <input type="text" class="form-control" name="guardian_name" id="guardian_name" value="" placeholder="Guardian Name">
                            <div id="error_allotment_guardian_name"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Relation</span>
                            <span class="text-red text-bold">*</span>
                            <select class="form-control" name="relation" id='relation'>
                                <option value="">Select Relation</option>
                                <?php foreach($relation as $rel):?>
                                    <option value="<?=$rel->guard_rel?>"><?=$rel->guard_rel_desc_as?></option>
                                <?php endforeach;?>
                            </select>
                            <div id="error_allotment_relation"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Gender</span>
                            <span class="text-red text-bold">*</span>
                            <select class="form-control" name="gender" id='gender'>
                                <option value="">Select Gender</option>
                                <?php foreach($genders as $r):?>
                                    <option value="<?=$r->id?>"><?=$r->gen_name_ass?></option>
                                <?php endforeach;?>
                            </select>
                            <div id="error_allotment_gender"></div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 pull-right">
                            <input type="submit" value="Save Applicant" class="btn btn-sm btn-primary" formnovalidate="">
                            <button type="button" class="btn btn-sm btn-default btnCloseApplicantModal">Close</button>
                            <input type="hidden" value="<?=$allotment_cb->case_no?>" name="case_no">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!---// End of Add New Applicant --->




<!---// Edit Applicant --->
<div class="modal" id="editAlloteeApplicant" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #136a6f; color: white">
                        <span class="text-bold">Update Applicant : &nbsp;&nbsp;<span id="alotee_name"></span></span>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold">Applicant`s Name</span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <input type="text" class="form-control" name="pet_name" 
                        id="applicantNam" placeholder="<?php echo $this->lang->line('applicants_name') ?>" value="">
                        <div id="alert_appl"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 applicant_guard_name main_guard">
                        <span class="text-bold"><?php echo $this->lang->line('guardian_name') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <input type="text" class="form-control guard_name" 
                        name="guard_name" id="guard_name" value=""
                        placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                        <div id="alert_guard_name"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold">Guardian Relation</span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" id="relation_guardian">
                        </select>
                        <div id="alert_rel"></div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                        <span class="text-bold"><?php echo $this->lang->line('gender') ?></span>
                        <span class="text-danger text-bold">&nbsp;*</span>
                        <select class="form-control" name="pet_gender" id='pet_gender'>
                        </select>
                        <div id="alert_gen"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-sm btn-info btnUpdateAllotee" id="appl_id" type="button"><b>Update Applicant</b></button>
                        <button type="button" class="btn btn-sm btn-default btnAlloteeCloseModal" id="">Close</button>
                        <input type="hidden" id="alotee_id" value="">
                        <input type="hidden" id="case_no" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!---// Edit Applicant --->
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>

    $('#BackHome').click(function(){
    location.href = "<?php echo base_url(); ?>index.php/home";
    });
    $(document).ready(function(){
        $('.pattaselect').on('change', function(event){
            event.preventDefault(event);
            var name = $("#case_no").val();
            var dataString = 'case_no='+ name;
            var pattacode = $(this).val();
                $.ajax({
                    type        : 'POST', 
                    url         : baseurl+'Allotment/dagSelectOnPattachange', 
                    data        : {'case_no': name,'pattacode': pattacode}, 
                    dataType    : 'json', 
                    encode      : true,
                    beforeSend: function(){
                                $("#loading").html("Validating ...Please wait...");
                                $('.alert').hide();
                                $('.disable_forward').hide();
                            },
                    success: function(data){
                      if(data.success!=null){
                        $("#loading").hide();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        $("#new_patta").val(data.new_patta);
                      }
                      if(data.error){
                        alert(data.error);
                        $('.disable_forward').show();
                      }
                    },
                    error:function(data){
                        if(data.error)
                        {
                            $('#msg').html('<div class="alert alert-info text-center">' + data.error + '</div>');   
                            $('.disable_forward').show();
                        }
                        else{
                        alert('Something went wrong');
                        $('.disable_forward').show();
                        }
                    }
                });
        });
    });
    ///////////////////////
    $(document).ready(function(){
    $(".numberonly").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }); 
    });
    /////////////////////
    // $('input:radio[name=optrad]').change(function() {
 //        if (this.value == 'Y') {
    //      var myValue = $(".new_dag" ).val();
    //      var myOValue = $(".new_s_dag" ).val();
    //      $( ".show_dag" ).val(myValue);
 //        }
 //        else if (this.value == 'N') {
 //            if($('#change_dag').val() == 0)
 //            {
 //                var myValue = $(".new_dag" ).val();
 //                var myOValue = $(".new_s_dag" ).val();
 //                $( ".show_dag" ).val(myOValue);    
 //            }
 //            else // if dag changed
 //            {
 //                var myOValue = $("#dag_list" ).val();
 //                $( ".show_dag" ).val(myOValue);
 //            }
 //        }
 //    });
    

    ///// 10-03-22 ///////
    $(document).on('click','.btnAddApplicant', function(e){
        e.preventDefault();
        $('#addNewApplicant_123').modal('show');

    });
    $(document).on('click','.btnCloseApplicantModal', function(e){
        e.preventDefault();
        $('#addNewApplicant_123').modal('hide');
    });

    $('#add_new_applicant').submit(function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Allotment/addNewAllotmentApplicant",
            type: 'POST',
            data: $("#add_new_applicant").serialize(),
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#error_allotment_'+value['field']).fadeIn();
                        $('#error_allotment_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#error_allotment_'+value['field']).fadeOut();
                        }, 30000);
                    });    
                }
                if(data.success)
                {
                    $('#addNewApplicant_123').modal('hide');
                    alert("New Applicant has successfully added");
                    window.location.href = baseurl + "Allotment/lmstep_one?case_no="+data.case;
                }
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });

    ///// 14-03-22 ///////
    $(document).on("click", ".btnApplicantEditCO", function(){
        id = $(this).attr('id');
        arr = id.split(',');
        alotee_id = arr[0];
        case_no = arr[1];
        $('#editAlloteeApplicant').modal('show');
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Allotment/getEditAllomentApplicantDetail",
            type:'POST',
            data:{alotee_id:alotee_id, case_no:case_no},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                if(data.alloted_applicant)
                { 
                    var template_rel = '';
                    for (var i = 0; i < data.relation.length; i++) {
                        
                        master_rel = data.relation[i].guard_rel;
                        appl_rel = data.alloted_applicant.alotee_reln;
                        rel_name = data.relation[i].guard_rel_desc_as;

                        template_rel += "<option value='" + master_rel + "' "+ ((master_rel.trim() === appl_rel.trim())?'selected':'') +">" + rel_name + "</option>";
                    }

                    var template_gen = '';
                    for (var j = 0; j < data.gender.length; j++) {
                        template_gen += "<option value='" + data.gender[j].id + "' "+ ((data.gender[j].id == data.alloted_applicant.alotee_gender)?'selected':'') +">" + data.gender[j].gen_name_ass + "</option>";
                    }

                    $('#alotee_name').html(data.alloted_applicant.alotee_name);
                    $('#relation_guardian').html(template_rel);
                    $('#pet_gender').html(template_gen);
                    $('#applicantNam').val(data.alloted_applicant.alotee_name);
                    $('#guard_name').val(data.alloted_applicant.alotee_gurdian);
                    $('#alotee_id').val(data.alloted_applicant.alotee_id);
                    $('#case_no').val(data.alloted_applicant.case_no);
                }
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });
    $(document).on('click','.btnAlloteeCloseModal', function(){
        $('#editAlloteeApplicant').modal('hide');
    });

    $(document).on('click', '.btnUpdateAllotee', function(){
        
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        alotee_id = $('#alotee_id').val();
        case_no = $('#case_no').val();
        appl = $('#applicantNam').val();
        guard_name = $('#guard_name').val();
        rel = $('#relation_guardian').val();
        gen = $('#pet_gender').val();

        $.ajax({
            url: baseurl + "Allotment/updateAllotedApplicant",
            type:'POST',
            data:{alotee_id:alotee_id, case_no:case_no, appl:appl, guard_name:guard_name, rel:rel, gen:gen},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                //console.log(data.details);
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 30000);
                    });    
                }
                if(data.details)
                {
                    alert("Alloted Applicant has successfully updated");
                    $('#editAlloteeApplicant').modal('hide');
                    $('#allotment_applicant_list').html(data.details);
                }
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });

    ///////// 24-03-22 //////////

    $(document).ready(function(){
        $('.changed_dag_no').hide();
        $('.changed_alloted_area').hide();
        $('.btnDagUnchange').hide();
        $('.dag_changed_upload_NOC').hide();

        tot_bigha = $('#tot_bigha').val();
        tot_katha = $('#tot_katha').val();
        tot_lessa = $('#tot_lessa').val();
        oDagNo = $(".new_s_dag").val();
        nDagNo = $(".new_dag").val();
    });
    
    $(document).on('click', '.btnDagUnchange', function(e){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        window.location.href = baseurl + "Allotment/lmstep_one?case_no="+$('#case').val();
        $.unblockUI();
    });
    
    $(document).on('click', '.btnDagChange', function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        id = $(this).attr('id');
        $(".new_s_dag" ).val('');
        $.ajax({
            url: baseurl + "Allotment/getDagList",
            type:'POST',
            data:{id:id},
            dataType:'json',
            success: function (data) {

                $.unblockUI();
                $('#change_dag').val('1');
                $('.lm_comment').text('');
                $('.old_dag_no').hide();
                $('.unchanged_alloted_area').hide();
                $('.btnDagChange').hide();

                $('.changed_dag_no').show();
                $('.changed_alloted_area').show();
                $('.btnDagUnchange').show();
                $('.dag_changed_upload_NOC').show();

                $('#tot_bigha').val('0');
                $('#tot_katha').val('0');
                $('#tot_lessa').val('0');
                $(".new_s_dag" ).val($('#dag_list').val());

                option = '<option value="">Select Dag No</option>';
                $.each(data.dag_details, function (i, val) { 
                    dag_no = val["dag_no"];
                    option += "<option value='" + dag_no +"'>" + dag_no + "</option>";
                });
                $('#dag_list').html(option);
                $('#patta_type_code').val(data.type_code);
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });

    $('#dag_list').on('change', function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        dag = $('#dag_list').val();
        dist = $('#dist_code').val();
        subdiv = $('#subdiv_code').val();
        cir = $('#cir_code').val();
        mouza = $('#mouza_pargona_code').val();
        vill = $('#vill_townprt_code').val();
        lot = $('#lot_no').val();

        $('#new_alot_b').val('0');
        $('#new_alot_k').val('0');
        $('#new_alot_lc').val('0');

        $.ajax({
            url: baseurl + "Allotment/changeAllotmentDag",
            type:'POST',
            data:{dag:dag, dist:dist, subdiv:subdiv, cir:cir, mouza:mouza, vill:vill, lot:lot},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                $('#tot_bigha').val(data.area.dag_area_b);
                $('#tot_katha').val(data.area.dag_area_k);
                $('#tot_lessa').val(data.area.dag_area_lc);
                $(".new_s_dag" ).val($('#dag_list').val());

                if($('#convDag1').prop('checked') == true){
                    $(".show_dag" ).val($('#dag_list').val());    
                }

                $('.lm_comment').text('');
                <?php 
                    ///////// BARAK VALLEY CODE STARTS HERE /////////////
                    if($barak) {
                ?>
                    $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর 0 বিঘা 0 কঠা 0 ছাটক 0 গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
                <?php } else { ?>
                    $('.lm_comment').text("আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  " +$('#dag_list').val()+" নং দাগৰ 0 বিঘা 0 কঠা 0 লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় ।");
                <?php } ///////// BARAK VALLEY CODE STARTS HERE ///////////// ?>

                
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });

    $('input:radio[name=optrad]').change(function() {
        if (this.value == 'Y') {
            var myValue = $(".new_dag" ).val();
            var myOValue = $(".new_s_dag" ).val();
            $( ".show_dag" ).val(myValue);
        }
        else if (this.value == 'N') {
            if($('#change_dag').val() == 0)
            {
                var myValue = $(".new_dag" ).val();
                var myOValue = $(".new_s_dag" ).val();
                $( ".show_dag" ).val(myOValue);    
            }
            else // if dag changed
            {
                var myOValue = $("#dag_list" ).val();
                $( ".show_dag" ).val(myOValue);
            }
        }
    });

    $('#new_alot_b').change(function(){
        $('.lm_comment').text('');
         <?php 
            ///////// BARAK VALLEY CODE STARTS HERE /////////////
            if($barak) {
        ?>
            $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর "+$('#new_alot_b').val()+" বিঘা 0 কঠা 0 ছাটক 0 গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
            landCalculation_kar();
        <?php } else { ?>
            $('.lm_comment').text("আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  "+ $('#dag_list').val()+" নং দাগৰ "+$('#new_alot_b').val()+" বিঘা 0 কঠা 0 লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় ।");
            landCalculation();
        <?php } ///////// BARAK VALLEY CODE STARTS HERE ///////////// ?>
    });

    $('#new_alot_k').change(function(){
        <?php 
            ///////// BARAK VALLEY CODE STARTS HERE /////////////
            if($barak) {
        ?>
            $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর "+$('#new_alot_b').val()+" বিঘা "+$('#new_alot_k').val()+" কঠা 0 ছাটক 0 গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
            landCalculation_kar();
        <?php } else { ?>
            $('.lm_comment').text("আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  "+$('#dag_list').val()+" নং দাগৰ "+$('#new_alot_b').val()+" বিঘা "+$('#new_alot_k').val()+" কঠা 0 লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় ।");
            landCalculation();
        <?php } ///////// BARAK VALLEY CODE STARTS HERE ///////////// ?>
    });

    $('#new_alot_lc').change(function(){

        $('.lm_comment').text('');
        <?php 
            ///////// BARAK VALLEY CODE STARTS HERE /////////////
            if($barak) {
        ?>
            $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর "+$('#new_alot_b').val()+" বিঘা "+$('#new_alot_k').val()+" কঠা "+$('#new_alot_lc').val()+" ছাটক 0 গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
            landCalculation_kar();
        <?php } else { ?>
            $('.lm_comment').text("আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  "+$('#dag_list').val()+" নং দাগৰ "+$('#new_alot_b').val()+" বিঘা "+$('#new_alot_k').val()+" কঠা "+$('#new_alot_lc').val()+" লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় ।");
            landCalculation();
        <?php } ///////// BARAK VALLEY CODE STARTS HERE ///////////// ?>
    });

    <?php 
        ///////// BARAK VALLEY CODE STARTS HERE /////////////
        if($barak) {
    ?>
    $('#new_alot_g').change(function(){
        $('.lm_comment').text('');
        $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর "+$('#new_alot_b').val()+" বিঘা "+$('#new_alot_k').val()+" কঠা "+$('#new_alot_lc').val()+" ছাটক "+$('#new_alot_g').val()+" গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
        landCalculation_kar();
    });
    <?php } ///////// BARAK VALLEY CODE STARTS HERE ///////////// ?>


    function landCalculation() 
    {
        var bigha = $('#tot_bigha').val();
        var katha = $('#tot_katha').val();
        var lessa = $('#tot_lessa').val();

        var mbigha = $('#new_alot_b').val();
        var mkatha = $('#new_alot_k').val();
        var mlessa = $('#new_alot_lc').val();

        if(parseInt(mkatha) >= 5)
        {
            bigha_cal = Math.floor((mkatha*20)/100);
            bigha_value = (mkatha*20)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = (kathareminder*100)/20;

            $('#new_alot_b').val(bigha_cal);
            $('#new_alot_k').val(katha_cal);
            $('#new_alot_lc').val(0);
        }

        //lessa katha calculation
        if(parseInt(mlessa) >= 20)
        {   
            katha_cal = Math.floor((mlessa)/20);
            katha_value = (mlessa)/20;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#new_alot_b').val(0);
            $('#new_alot_k').val(katha_cal);
            $('#new_alot_lc').val(lessa_cal);
         }

        //lessa bigha calculation
        if(parseInt(mlessa) >= 100)
        {   
            bigha_cal = Math.floor((mlessa)/100);
            bigha_value = (mlessa)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = Math.floor((kathareminder*20)/100);
            katha_value = (kathareminder*20)/100;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#new_alot_b').val(bigha_cal);
            $('#new_alot_k').val(katha_cal);
            $('#new_alot_lc').val(lessa_cal);
        }

        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        
        if (window.sourcelessa < window.targetlessa) {
            alert('Mutated Land Area should be less than the area available in Chitha..');

            $('#new_alot_b').val(0);
            $('#new_alot_k').val(0);
            $('#new_alot_lc').val(0);

            $('.lm_comment').text('');
            $('.lm_comment').text("আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  "+$('#dag_list').val()+" নং দাগৰ 0 বিঘা 0 কঠা 0 লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় ।");
        }
    }

    function landCalculation_kar() 
    {
        var bigha = $('#tot_bigha').val();
        var katha = $('#tot_katha').val();
        var lessa = $('#tot_lessa').val();
        var ganda = $('#tot_ganda').val();        

        var mbigha = $('#new_alot_b').val();
        var mkatha = $('#new_alot_k').val();
        var mlessa = $('#new_alot_lc').val();
        var mganda = $('#new_alot_g').val();

        if(parseInt(mkatha) >= 20)
        {
            alert("Maximum allowed size is 19.99");
            $('#new_alot_b').val(0);
            $('#new_alot_k').val(0);
            $('#new_alot_lc').val(0);
            $('#new_alot_g').val(0);
        }

        if(parseInt(mlessa) >= 320)
        {
            alert("Maximum allowed size is 319.99");
            $('#new_alot_b').val(0);
            $('#new_alot_k').val(0);
            $('#new_alot_lc').val(0);
            $('#new_alot_g').val(0);
        }

        if(parseInt(mganda) >= 6400)
        {   
            alert("Maximum allowed size is 6399.99");
            $('#new_alot_b').val(0);
            $('#new_alot_k').val(0);
            $('#new_alot_lc').val(0);
            $('#new_alot_g').val(0);
        }

        sourcelessa = parseInt(bigha)*6400+parseInt(katha)*320+parseInt(lessa)*20+parseInt(ganda);
        targetlessa = parseInt(mbigha)*6400+parseInt(mkatha)*320+parseInt(mlessa)*20+parseInt(mganda);
        
        if (sourcelessa < targetlessa) {
            alert('Mutated Land Area should be less than the area available in Chitha..');
            $('#new_alot_b').val(0);
            $('#new_alot_k').val(0);
            $('#new_alot_lc').val(0);
            $('#new_alot_g').val(0);
            $('.lm_comment').text('');
            $('.lm_comment').text("আবেদনকারী <?php echo $mouzaname?>মৌজার <?php echo $villname?> গ্ৰাম্র  " +$('#dag_list').val()+" নং দাগর 0 বিঘা 0 কঠা 0 ছাটক 0 গন্ডা মাটি  <?php echo $dag_details->case_no; ?> বরাদ্দপত্র নং বরাদ্দপত্রটি বরাদ্দের শংসাপত্র অনুসারে ভোগের দায়িত্ব গ্রহণ করতে দেখা গেছে ৷ বরাদ্দকৃত মাটি <?php echo $villname?> গ্রামীণ এলাকার মধ্যে জামি । সরকারি নির্দেশনা অনুযায়ী, জমি বরাদ্দ দেওয়া যেতে পারে ।");
        }
    }

    $("#lm_submit").submit(function(e){
        $('#msg1').hide();
        $('#msg1 .alert').hide();
        e.preventDefault();
        flag = $('#change_dag').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Allotment/lm_submit",
            type:'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                //console.log(data);
                //alert(flag);
                if(data.audit){
                    $('#msg1').show();
                    $('#msg1 .alert').show();
                    $('#msg1 .alert').html(data.audit);
                    return false;
                }
                if(data.error && flag == 1){
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 30000);
                    });
                    return false;
                }

                if(data.error_a && flag==1){
                    $('#err_message').html('');
                    var error_message = '';

                    $.each(data.error_a, function (index, value) {
                        $('#err_message').fadeIn();
                        error_message += value['err_msg'];
                    });
                    $('#err_message').html(error_message);
                    setTimeout(function(){
                            $('#err_message').fadeOut();
                        }, 30000);
                    return false;
                }

                if(data.error1){
                    $.each(data.error1, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 30000);
                    });    
                }    

                if(data.errorMessage != null){
                    $('#err_message').html(data.errorMessage);
                }
            
                if(data.success == 'true'){
                    alert("Case has successfully forwarded for case no "+ data.case_no);
                    window.location.href = data.redirect;
                }
                
                if(data.location == 'true'){
                    window.location.href = data.redirect;   
                }
            },
            error: function(data){
                alert("Unable to Process");
                $.unblockUI();
            }
        });
    });

</script>
