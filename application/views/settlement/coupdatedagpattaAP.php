
<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
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
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

    })

</script>




<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
			
			  <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Settlement/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
					
					
					                <?php 
                                    if($allotment_certificate->name_of_certificate){
                                        ?>
                                        <a href="javascript:void(0);" data-path="<?php echo search_file_location('APPPDocs/'. $allotment_certificate->name_of_certificate); ?>" class="preview__file btn btn-info" >
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
                                        <a href="javascript:void(0);" data-path="<?php echo search_file_location('APPPDocs/'. $allotment_certificate->rev_certificate); ?>" class="preview__file btn btn-info">
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
                                        <a href="javascript:void(0);" data-path="<?php echo search_file_location('APPPDocs/'. $allotment_certificate->premium_certificate); ?>" class="preview__file btn btn-info">
                                            <i class="fa fa-paperclip"></i>&nbsp;View Premium Against Challan 
                                        </a>
                                        <?php
                                    } else {
                                        echo '<h6> No Documents Uploaded</h6>';
                                    }
                                    ?>
					
					
                   <!-- <a class="btn btn-success uni_text" target='_blank'  href='<?php //echo base_url() . 'index.php/Settlement/viewcert?case_no=' . $allotment_certificate->name_of_certificate ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Settlement Certificate
                    </a> 
					
					  <a class="btn btn-primary uni_text" target='_blank'  href='<?php// echo base_url() . 'index.php/Settlement/viewcertrev?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Certificate from Revenue
                    </a>
					
					
					 <a class="btn btn-success uni_text" target='_blank'  href='<?php //echo base_url() . 'index.php/Settlement/viewcertpre?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Premium Against Challan
                    </a>
					
					
					<a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php //echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a> !-->
                </div>
			
			
			
                <form class="form-horizontal unicode" action="<?php echo base_url() . "index.php/Settlement/updatechithaallotmentAP" ?>" method="POST"  >   
                    <input type='hidden' name='case_no' value='<?= $alm->case_no; ?>' >
                    <div class='panel-body'>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control numberonly" placeholder='Dag Number' value='<?php echo $new_dag; ?>' name="new_dag" required="" value="" >
                            </div>
                            <label for="inputEmail" class="col-lg-4 red control-label ">New Periodic Patta Proposed </label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control numberonly" value='<?php echo $new_patta; ?>' placeholder='Patta Number' name="new_patta" required="" value="" >
                            </div>
                        </div>
                        <div class="form-group hide">    
                            <label for="inputEmail" class="col-lg-3 green control-label ">New Dag Patta Type </label>
                            <div class="col-lg-2">
                                <select class="form-control" name="new_patta_type">
                                    <?php foreach ($mutpatta as $np): ?>
                                        <option value='<?= $np->type_code ?>'><?= $np->patta_type ?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                            <label for="inputEmail" class="col-lg-4 green control-label ">New Dag Landclass Code </label>
                            <div class="col-lg-2">
                                <select class="form-control" name="new_landcode">
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
						
						 <!-- <div class="form-group ">    
                               <label for="inputEmail" class="col-lg-3 uni_text control-label">Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popupDatepicker' name="cert_date"  class="form-control"  >
                                </div>  
                        </div> !-->
						
						
                        <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Modify and View LM Note </label>
                            <div class="col-lg-9">
                                <textarea rows='5'  name="" readonly="" class="form-control"><?= $lmnote->lm_comment; ?></textarea>
								</div>
								</div>
								  <div class="form-group">    
                            <label for="inputEmail" class="col-lg-3  control-label ">CO Note</label>
								  <div class="col-lg-9">
								 
								 <textarea class="form-control" rows=10 placeholder='Type here' name="coComment" required="" value="" >অসম চৰকাৰৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->govt_date_of_issue));?>ইং তাৰিখৰ <?php echo $allotment_certificate123->govtcertificate_no; ?>নং চিঠি আৰু কামৰুপ জিলাৰ উপায়ুও মহোদয়ৰ<?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?>নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ<?php echo date("d/m/Y"); ?>ইং তাৰিখৰ নিদেৰ্শ মৰ্মে  ১চনা <?php echo ($dag_details->dag_no/100); ?> নং দাগৰ জমিৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> লেছা  মাটি <?php  echo date('d/m/Y',strtotime($allotment_certificate123->challandate)); ?>ইং তাৰিখৰ<?php echo $allotment_certificate123->challancert_no;   ?>নং চালান যোগে<?php echo $dag_details->premium; ?>টকা প্ৰিমিয়াম আদায় ক্রমে নতুন<?php echo $applicant->alotee_name;?>পিতা  <?php echo $applicant->alotee_gurdian;?>_নামত  <?php echo $new_dag; ?> নং দাগ আৰু <?php echo $new_patta; ?>নং খেৰাজ ম্যাদী পট্টা ভুত্ত কৰা হল। </textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
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
    });
</script>