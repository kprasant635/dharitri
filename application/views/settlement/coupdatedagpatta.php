
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
            <div class="panel panel-info panel-form">
            <div class="well well-sm mis_report">
                    <h3 class="text-center">Settlement CO`s Final order</h3>
                </div>
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
              <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Settlement/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    
                                    <?php
                                    if($allotment_cb->name_of_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_cb->name_of_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Settlement Certificate
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_cb->name_of_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Settlement Certificate
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                                      <?php
                                    if($allotment_cb->rev_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_cb->rev_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Certificate from Revenue
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_cb->rev_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Certificate from Revenue
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                     <?php
                                    if($allotment_cb->premium_certificate){
                                        ?>
                                        <!-- <a href="<?php echo base_url(); ?>STPPDocs/<?php echo $allotment_cb->premium_certificate; ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Premium Against Challan
                                        </a> -->
                                        <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_cb->premium_certificate); ?>" class="preview__file btn btn-info" target="_blank">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Premium Against Challan
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>

                  <!--  <a class="btn btn-success uni_text" target='_blank'  href='<?php //echo base_url() . 'index.php/Settlement/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Settlement Certificate
                    </a>
                    
                      <a class="btn btn-primary uni_text" target='_blank'  href='<?php //echo base_url() . 'index.php/Settlement/viewcertrev?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Certificate from Revenue
                    </a>
                    
                    
                     <a class="btn btn-success uni_text" target='_blank'  href='<?php //echo base_url() . 'index.php/Settlement/viewcertpre?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Premium Against Challan
                    </a> !-->
                    
                    
                    <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
                </div>
            
                <div>&nbsp;</div>
            
                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Settlement/updatechithaallotment" ?>" method="POST"  >   
                    <input type='hidden' name='case_no' value='<?= $alm->case_no; ?>' >
                    <div class='panel-body'>
                        <div class="form-group ">
                                
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control numberonly" placeholder='Dag Number' value='<?php echo $newdag; ?>' name="new_dag" required="" value="" >
                            </div>
                            
                        </div>
                        <div class="form-group"> 
                            <label for="inputEmail" class="col-lg-3 green control-label ">New Patta Type </label>
                            <div class="col-lg-2">
                                <input type="hidden" name="case_no" id="case_no" value='<?php echo $_GET['case_no'];?>'>
                                <select  class="form-control pattaselect" id="select" name="new_patta_type">
                                    <option selected value="<?=$selectedPattaType?>"><?=$this->utilityclass->getPattaName($selectedPattaType);?></option>
                                    <?php foreach ($mutpatta as $np) { ?>
                                        <option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
                                    <?php } ?>
                                </select>   
                            </div>    
                            <label for="inputEmail" class="col-lg-4 red control-label ">New Periodic Patta Proposed </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control numberonly" value='<?php echo $newpatta; ?>' readonly placeholder='Patta Number' name="new_patta" id='new_patta' required="" value="" >
                            </div>
                            <span id='loading' class="text-danger" style="display:none">Please Wait ...Checking New Patta No</span>
                        </div>
                        <div class="form-group hide">    
                            <label for="inputEmail" class="col-lg-3 green control-label ">New Dag Patta Type </label>
                            <div class="col-lg-2">
                                <select class="form-control" >
                                    <?php foreach ($mutpatta as $np): ?>
                                        <option value='<?=$np->type_code ?>'><?= $np->patta_type ?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                            <label for="inputEmail" class="col-lg-4 green control-label ">New Dag Landclass Code </label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($landsql as $np): ?>
                                        <option value='<?= $np->class_code ?>'><?= $np->land_type ?></option>
                                    <?php endforeach; ?>
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Check Existing Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->dag_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="inputEmail" class="col-lg-4 control-label ">Check Existing Patta</label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->patta_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                            <div class="col-lg-2">
                                <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue" required="" value="<?php echo $l_rev_local->l_rev?>" >
                            </div>
                            <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                            <div class="col-lg-2">
                                <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax" required="" value="<?php echo $l_rev_local->l_tax?>" >
                            </div>
                        </div>

                        <div class="form-group"> 
                       
                            <div class="col-lg-6 offset-md-3" style="background-color:#ffb81d;padding: 24px;box-shadow: 0px 0px 4px #000">
                                <b style="font-size: 19px;color: #cf0606;">Zonal Value for Existing Dag No :  <span style="font-size: 17px;">(<?=$old_dag?> )  &nbsp;&nbsp;&nbsp; <kbd> <?=$zonalValueOfDag == null ? "N/A" : $zonalValueOfDag ;?></kbd></span> </b>
                                <hr>
                                <?php
                                if($zonalValueOfDag != null){
                                    echo "<b>NOTE : Same will be updated in new dag after CO Final Order.</b>";
                                }else{
                                    echo "<b>NOTE: No updation will be done against the new dag no.</b>";
                                }
                                ?>
                                
                            </div>
                          
                        </div>


                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Modify and View LM Note </label>
                            <div class="col-lg-9">
                                <textarea rows='5'  name="lmComment" class="form-control"><?= $lmnote->lm_comment; ?></textarea>
                            </div>
                        </div>


                        
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">CO Note</label>
                            <div class="col-lg-9">
                            <?php
                            $dist_code = $this->session->userdata('dist_code');
                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                 
                            <textarea class="form-control" rows=10 placeholder='Type here' name="coComment" required="" value="" >অসম চৰকাৰৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?> ইং তাৰিখৰ <?php echo $allotment_certificate123->govtcertificate_no; ?> নং চিঠি আৰু <?php  echo $dist_name; ?> জিলাৰ উপায়ুক্ত মহোদয়ৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?> নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ <?php echo date("d/m/Y"); ?> ইং তাৰিখৰ <?php echo $case_no; ?>  নং গোচৰৰ নিদেৰ্শ মৰ্মে   <?php echo $dag_details->dag_no; ?> নং দাগৰ জমিৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> চাটক  মাটি <?php echo $dag_details->alot_area_g; ?> গন্ডা <?php // echo date('d/m/Y',strtotime($allotment_certificate123->challandate)); ?><?php //echo $allotment_certificate123->challancert_no;   ?> <?php echo $dag_details->premium; ?> টকা প্ৰিমিয়াম আদায় ক্রমে  <?php echo $applicant->alotee_name;?>পিতা  <?php echo $applicant->alotee_gurdian;?>_নামত  নতুন <?php echo $newdag; ?> নং দাগ আৰু নতুন<?php echo $newpatta; ?>নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰা হল।   </textarea>
                            </div>
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
                                
                                <input type="hidden" id="new_dag" value="<?php echo $newdag; ?>">

                                <textarea class="form-control" rows=10 placeholder='Type here' name="coComment" required="" value="" id="co_comment" >অসম চৰকাৰৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?> ইং তাৰিখৰ <?php echo $allotment_certificate123->govtcertificate_no; ?> নং চিঠি আৰু <?php  echo $dist_name; ?> জিলাৰ উপায়ুক্ত মহোদয়ৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?> নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ <?php echo date("d/m/Y"); ?> ইং তাৰিখৰ <?php echo $case_no; ?>  নং গোচৰৰ নিদেৰ্শ মৰ্মে   <?php echo $dag_details->dag_no; ?> নং দাগৰ জমিৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> লেছা  মাটি <?php // echo date('d/m/Y',strtotime($allotment_certificate123->challandate)); ?><?php //echo $allotment_certificate123->challancert_no;   ?> <?php echo $dag_details->premium; ?> টকা প্ৰিমিয়াম আদায় ক্রমে  <?php echo $applicant->alotee_name;?>পিতা  <?php echo $applicant->alotee_gurdian;?>_নামত  নতুন <?php echo $newdag; ?> নং দাগ আৰু <?php echo $newpatta; ?> পট্টা ভুক্ত কৰা হল।   </textarea>
                            <?php }?>
                        </div>
                        
                        <div class="">
                            <input type="hidden"  class="numberonly form-control" name="mouza_pargona_code" value="<?= $alm->mouza_pargona_code; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="lot_no" required="" value="<?= $alm->lot_no; ?>" >
                            <input type="hidden"  class="numberonly form-control" name="vill_townprt_code" value="<?= $alm->vill_townprt_code; ?>" >
                            <button type="submit" name="submit" class="col-lg-offset-4 btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                            <div class="btn btn-info  uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                       

                         
                                
                                     <a class="btn btn-success uni_text" target='_blank'  href='<?php echo base_url() . 'index.php/Settlement/Reject?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; Reject
                    </a>
                  
                       </div>
                </form>

            </div>
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
    $('#BackHome').click(function () {
        location.href = "<?php echo base_url(); ?>index.php/home";
    });
    $(document).ready(function () {
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
        $('.pattaselect').on('change', function(event){
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
                                $("#loading").show();
                                $('.btn-primary').hide();
                            },
                    success: function(data){
                      if(data.success!=null){
                        var co_comment="অসম চৰকাৰৰ  "+$("#govt_date_of_issue").val()+" ইং তাৰিখৰ "+$("#govtcertificate_no").val()+" নং চিঠি আৰু উপায়ুক্তৰ "+$("#date_of_issue").val()+" ইং তাৰিখৰ   "+$("#certficate_no").val()+" নং চিঠিৰ হকুমৰ্মে "+$("#dag_no").val()+"  নং দাগৰ  "+$("#alot_area_b").val()+" বিঘা "+$("#alot_area_k").val()+" কঠা "+$("#alot_area_lc").val()+" লেছা  মাটিৰ "+$("#premium").val()+" টকা প্ৰিমিয়াম আদায় ক্রমে আবেদনকাৰী "+$("#alotee_name").val()+" পিতা  "+$("#alotee_gurdian").val()+" নামত "+$("#new_dag").val()+"   নং দাগত আৰু "+data.new_patta+" "+$(".pattaselect option:selected").text()+" পট্টা দিব পৰা যায়  । ";

                        $("#loading").hide();
                        $('.btn-primary').show();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        $("#new_patta").val(data.new_patta);
                        $("#co_comment").text(co_comment);
                      }
                    },
                    error:function(data){
                        alert('Something went wrong');
                    }
                });
        });
    });
</script>
