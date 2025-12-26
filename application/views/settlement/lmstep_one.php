<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modala .modal-body').html(data);
                    $('#modala').modal('show');
                    $('#modala .modal-body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalb .modal-body').html(data);
                    $('#modalb').modal('show');
                    $('#modalb .modal-body').addClass('bodytest');
                }
            });

        });

        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalc .modal-body').html(data);
                    $('#modalc').modal('show');
                    $('#modalc .modal-body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div id="modala" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalb" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalc" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-default panel-body">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Settlement/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    
                                    <?php
                                    if($allotment_certificate->name_of_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_certificate->name_of_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Settlement Certificate
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_certificate->name_of_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Settlement Certificate
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                                     <?php
                                    if($allotment_certificate->rev_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_certificate->rev_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Certificate from Revenue
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_certificate->rev_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Certificate from Revenue
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                    <?php
                                    if($allotment_certificate->premium_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_certificate->premium_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Premium Against Challan
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_certificate->premium_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Premium Against Challan
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                    
                   <!-- <a class="btn btn-success uni_text" target='_blank'  href='<?php echo base_url() . 'index.php/Settlement/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Settlement Certificate from DC
                    </a>
                    
                     <a class="btn btn-primary uni_text" target='_blank'  href='<?php echo base_url() . 'index.php/Settlement/viewcertrev?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Certificate from Revenue
                    </a>
                    
                    
                     <a class="btn btn-success uni_text" target='_blank'  href='<?php echo base_url() . 'index.php/Settlement/viewcertpre?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Premium Against Challan
                    </a>
                    <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChithaSettlement?case_no=' . $allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
                </div> !-->
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
            
                <form class="form-horizontal unicode" action="<?php echo base_url()."index.php/Settlement/lm_submit" ?>" method="POST"  >              
                <div class='panel-body'>
                <br>
                    <h2 class="text-center" style="top:20px;">Report By Lot Mondal</h2>
                    
                    <h4 class="center hide red "><u>Schedule Of Land Settled</u></h4>
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
                    <hr>
                    <?php
                          $dist_code = $this->session->userdata('dist_code');
                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <div class="form-group">
                    
                                <label for="inputEmail" class="col-lg-2  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly class="form-control" value='<?php echo $dag_details->tot_area_b;?>' placeholder='Bigha' name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly value='<?php echo $dag_details->tot_area_k;?>'  class="form-control" placeholder='Katha' name="tot_katha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly value='<?php echo $dag_details->tot_area_lc;?>'  class="form-control" name="tot_lessa" placeholder='Chatak' required="" >
                                </div> 
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly value='<?php echo $dag_details->tot_area_g;?>'  class="form-control" name="tot_ganda" placeholder='Ganda' required="" >
                                </div>  
                    </div>
                    <div class="form-group">
                                <label for="inputEmail" class="col-lg-2  control-label red">Area Settled   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly  class="form-control" value='<?php echo $dag_details->alot_area_b;?>'  required="" placeholder='Bigha' >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly class="form-control" value='<?php echo $dag_details->alot_area_k;?>'  placeholder='Katha' required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly class="form-control" value='<?php echo $dag_details->alot_area_lc;?>' placeholder='Chatak' required=""  >
                                </div> 
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda  </label>
                                <div class="col-lg-1">
                                    <input type="text" readonly class="form-control" value='<?php echo $dag_details->alot_area_g;?>' placeholder='Ganda' required=""  >
                                </div>  
                    </div>

                    <?php }else{?>
                    <div class="form-group">
                    
                                <label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text" readonly class="form-control" value='<?php echo $dag_details->tot_area_b;?>' placeholder='Bigha' name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text" readonly value='<?php echo $dag_details->tot_area_k;?>'  class="form-control" placeholder='Katha' name="tot_katha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text" readonly value='<?php echo $dag_details->tot_area_lc;?>'  class="form-control" name="tot_lessa" placeholder='Lessa' required="" >
                                </div>  
                    </div>
                    <div class="form-group">
                                <label for="inputEmail" class="col-lg-3  control-label red">Area Settled   </label>
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

                <?php }?>
                    
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether Settled certificate is checked and found ok ?  </label>
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
                <!--    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether Settled is a recorded tenant ?  </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec"  value="Y" checked="">
                                        <?php //echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec"  value="N" >
                                        <?php //echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                    </div> !-->
                    <div class="form-group hide" >    
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
                                <select class='form-control' name='land_use' required>
                                    <option value='0'>Select Option</option>
                                    <option value='Resindential'>Residential</option>       
                                        
                                    <option value='Cultivation'>Industrial</option>
                                    <option value='Others'>Others</option>      
                                <select>
                                </div>
                    </div>
                    <div class="hide form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether the settled area applied for PP falls within 3 KM radius of Town </label>
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
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether the settled area applied for PP falls within 10 KM radius of GMC </label>
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
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Area For Settlement</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Bigha' value='<?php echo $dag_details->alot_area_b;?>' name="p_bigha" required="" value="" >
                                    Bigha
                                </div>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Katha' value='<?php echo $dag_details->alot_area_k;?>' name="p_katha" required="" value="" >
                                    Katha
                                </div>
                                
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Chatak' value='<?php echo $dag_details->alot_area_lc;?>' name="p_lessa" required="" value="" >
                                Chatak
                                </div>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Ganda' value='<?php echo $dag_details->alot_area_g;?>' name="p_ganda" required="" value="" >
                                    Ganda
                                </div>
                                <?php }else{?>
                                    <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Lessa' value='<?php echo $dag_details->alot_area_lc;?>' name="p_lessa" required="" value="" >
                                    Lessa
                                </div>
                                <?php }?>

                                 
                    </div>
                 
                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-3 green required control-label ">New Dag Patta Type </label>
                               <div class="col-lg-2">
                            <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case_no'];?>'>
                            <select  class="form-control pattaselect" id="select" required name="new_patta_type">
                            <option selected disabled>Select Patta type</option>
                            <?php foreach ($mutpatta as $np) { ?>
                                <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                            <?php } ?>
                            </select>
                        </div>
                                <label for="inputEmail" class="col-lg-4 green control-label ">New Dag Landclass Code </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="new_landcode">
                                        <?php foreach($landsql as $np): ?>
                                        <option value='<?=$np->class_code?>'><?=$np->land_type?></option>
                                        <?php endforeach; ?>
                                    </select>
                                   
                                </div>
                    </div>

                    <div class="form-group ">    
                        <label for="inputEmail" class="col-lg-3 red control-label ">New Periodic Patta Proposed </label>
                        <div class="col-lg-2">
                            <input type="text" id='new_patta' class="form-control" placeholder='Patta Number' name="new_patta" required value="" >
                        </div>
                        <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                        <div class="col-lg-2">
                            <input type="text"  class="form-control show_dag" placeholder='Dag Number' value='<?php echo $new_dag; ?>' name="new_dag" required="" >
                        </div>
                        <div class="col-lg-3" style="display: none">
                            <input type="text"  class="form-control new_dag"  value='<?php echo $new_dag; ?>'  >
                            <input type="text"  class="form-control new_s_dag"  value='<?php echo $dag_details->dag_no;?>'  >
                        </div>
                    </div>
                    
                    
                    <div class="form-group hide ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Existing TB Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_revenue" required value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Existing Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_local_tax" required value="" >
                                </div>
                    </div>
                    
                    
                    
                    
                    
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue" id='P_land' required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax" id='p_loc_tax' required="" value="" >
                                </div>
                    </div>
                    <?php //var_dump($mouzaname);?>
                    <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                                <div class="col-lg-10">
                                   <!-- <textarea class="form-control" rows=10 placeholder='Type here' name="lm_comment" required="" value="" >আবেদনকাৰী য়ে <?php //echo $mouzaname?>মৌজাৰ <?php //echo $villname?> গাওৰ  <?php //echo $dag_details->dag_no; ?> নং দাগৰ  <?php //echo $dag_details->alot_area_b; ?> বিঘা <?php //echo $dag_details->alot_area_k; ?> কঠা <?php //echo $dag_details->alot_area_lc; ?> লেছা  মাটি  <?php //echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php //echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় । </textarea> !-->
                           <?php if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                             <input type="hidden" id="govt_date_of_issue" value="<?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?>">
                                <input type="hidden" id="govtcertificate_no" value="<?php echo $allotment_certificate123->govtcertificate_no; ?>">
                                <input type="hidden" id="date_of_issue" value="<?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?>">
                                <input type="hidden" id="certficate_no" value="<?php  echo $allotment_certificate123->certficate_no; ?>">
                                
                                <input type="hidden" id="dag_no" value="<?php echo $dag_details->dag_no; ?>">
                                <input type="hidden" id="alot_area_b" value="<?php echo $dag_details->alot_area_b; ?>">
                                <input type="hidden" id="alot_area_k" value="<?php echo $dag_details->alot_area_k; ?>">
                                <input type="hidden" id="alot_area_lc" value="<?php echo $dag_details->alot_area_lc; ?>">
                                <input type="hidden" id="premium" value="<?php echo $dag_details->premium; ?>">
                                <input type="hidden" id="alotee_name" value="<?php echo $applicant->alotee_name;?>">
                                <input type="hidden" id="alotee_gurdian" value="<?php echo $applicant->alotee_gurdian;?>">
                                
                                <input type="hidden" id="new_dag" value="<?php echo $new_dag; ?>">
                             <textarea class="form-control" rows=10 placeholder='Type here' name="lm_comment" required="" value="" id="lm_comment">অসম চৰকাৰৰ  <?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?> ইং তাৰিখৰ <?php echo $allotment_certificate123->govtcertificate_no; ?> নং চিঠি আৰু উপায়ুক্তৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?> নং চিঠিৰ হকুমৰ্মে <?php echo $dag_details->dag_no; ?>  নং দাগৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> চাটক <?php echo $dag_details->alot_area_g; ?> গন্ডা মাটিৰ <?php echo $dag_details->premium; ?> টকা প্ৰিমিয়াম আদায় ক্রমে আবেদনকাৰী <?php echo $applicant->alotee_name;?> পিতা  <?php echo $applicant->alotee_gurdian;?> নামত   <?php echo $new_dag; ?>  নং দাগ পট্টা দিব পৰা যায় । </textarea>

                             <?php }else{?>
                                <input type="hidden" id="govt_date_of_issue" value="<?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?>">
                                <input type="hidden" id="govtcertificate_no" value="<?php echo $allotment_certificate123->govtcertificate_no; ?>">
                                <input type="hidden" id="date_of_issue" value="<?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?>">
                                <input type="hidden" id="certficate_no" value="<?php  echo $allotment_certificate123->certficate_no; ?>">
                                
                                <input type="hidden" id="dag_no" value="<?php echo $dag_details->dag_no; ?>">
                                <input type="hidden" id="alot_area_b" value="<?php echo $dag_details->alot_area_b; ?>">
                                <input type="hidden" id="alot_area_k" value="<?php echo $dag_details->alot_area_k; ?>">
                                <input type="hidden" id="alot_area_lc" value="<?php echo $dag_details->alot_area_lc; ?>">
                                <input type="hidden" id="premium" value="<?php echo $dag_details->premium; ?>">
                                <input type="hidden" id="alotee_name" value="<?php echo $applicant->alotee_name;?>">
                                <input type="hidden" id="alotee_gurdian" value="<?php echo $applicant->alotee_gurdian;?>">
                                
                                <input type="hidden" id="new_dag" value="<?php echo $new_dag; ?>">
                                
                                 <textarea class="form-control" rows=10 placeholder='Type here' name="lm_comment" required="" value="" id="lm_comment" >অসম চৰকাৰৰ  <?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?> ইং তাৰিখৰ <?php echo $allotment_certificate123->govtcertificate_no; ?> নং চিঠি আৰু উপায়ুক্তৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?> নং চিঠিৰ হকুমৰ্মে <?php echo $dag_details->dag_no; ?>  নং দাগৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> লেছা  মাটিৰ <?php echo $dag_details->premium; ?> টকা প্ৰিমিয়াম আদায় ক্রমে আবেদনকাৰী <?php echo $applicant->alotee_name;?> পিতা  <?php echo $applicant->alotee_gurdian;?> নামত   <?php echo $new_dag; ?>  নং দাগত পট্টা দিব পৰা যায়  । </textarea>
                            <?php }?>

                               </div>
                                
                    </div>
                <div class="panel-footer">
                    
                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                   
<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                </div>
                </form>
                
            </div>
         </div>
        
    </div>
    </div>    
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>


<script>




  $('#P_land').keyup(function (e) {
        var P_land_rev = $(this).val();
        var loc_tax = (P_land_rev) / 4;
       // var tot_rev = $('#tot_rev').val();
        //alert (loc_tax);
        var total = parseFloat(loc_tax) + parseFloat(P_land_rev);
        window.sourcelessa = total;
        console.log(window.sourcelessa);
        //alert (window.sourcelessa);
        $('#p_loc_tax').val(loc_tax);
       // $('#rev_diff').val(parseFloat(window.sourcelessa - tot_rev).toFixed(2));
    });








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

                        var lm_comment="অসম চৰকাৰৰ  "+$("#govt_date_of_issue").val()+" ইং তাৰিখৰ "+$("#govtcertificate_no").val()+" নং চিঠি আৰু উপায়ুক্তৰ "+$("#date_of_issue").val()+" ইং তাৰিখৰ   "+$("#certficate_no").val()+" নং চিঠিৰ হকুমৰ্মে "+$("#dag_no").val()+"  নং দাগৰ  "+$("#alot_area_b").val()+" বিঘা "+$("#alot_area_k").val()+" কঠা "+$("#alot_area_lc").val()+" লেছা  মাটিৰ "+$("#premium").val()+" টকা প্ৰিমিয়াম আদায় ক্রমে আবেদনকাৰী "+$("#alotee_name").val()+" পিতা  "+$("#alotee_gurdian").val()+" নামত "+$("#new_dag").val()+"   নং দাগত আৰু "+data.new_patta+" "+$(".pattaselect option:selected").text()+" পট্টা দিব পৰা যায়  । ";

                        $("#loading").hide();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        $("#new_patta").val(data.new_patta);
                        $("#lm_comment").text(lm_comment);
                      }
                      if(data.error)
                      {
                        alert(data.error);
                        $('.disable_forward').show();
                      }
                    },
                    error:function(data){
                        alert('Something went wrong');
                    }
                });
        });
    });
    /////////////
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
</script>

