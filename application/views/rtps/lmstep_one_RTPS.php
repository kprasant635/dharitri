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
                </div>


                <form class="form-horizontal" method="POST" id="lm_submit" enctype="multipart/form-data">
                <div class='panel-body'>
				<br>
                    <h2 class="text-center" style="top:20px;">Report By Lot Mondal (RTPS)</h2><hr>
					
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
					</div>

                    <div class="form-group">
								
						<label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                        <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                        <div class="col-lg-2">
                            <input type="text" readonly class="form-control" value='<?php echo $dag_details->tot_area_b;?>' placeholder='Bigha' name="tot_bigha" id="tot_bigha" required="" >
                        </div>
                        <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                        <div class="col-lg-2">
                            <input type="text" readonly value='<?php echo $dag_details->tot_area_k;?>'  class="form-control" placeholder='Katha' name="tot_katha" id="tot_katha" required="" >
                        </div>
                        <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                        <div class="col-lg-2">
                            <input type="text" readonly value='<?php echo $dag_details->tot_area_lc;?>'  class="form-control" name="tot_lessa" placeholder='Lessa' id="tot_lessa" required="" >
                        </div>  
                    </div>

                    
					<div class="form-group">
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
                            <input type="text" id='new_patta' class="form-control" placeholder='Patta Number' name="new_patta" required="" value="" >
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
                        
                        <div class="col-lg-10">
                            <textarea class="form-control lm_comment" rows=10 
                            placeholder='Type here' name="lm_comment" value="">আবেদনকাৰী য়ে <?php echo $mouzaname?>মৌজাৰ <?php echo $villname?> গাওৰ  <?php echo $dag_details->dag_no; ?> নং দাগৰ  <?php echo $dag_details->alot_area_b; ?> বিঘা <?php echo $dag_details->alot_area_k; ?> কঠা <?php echo $dag_details->alot_area_lc; ?> লেছা  মাটি  <?php echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় । </textarea>
                            <div id="alert_lm_comment"></div>
                        </div>

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

                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                <div id="div_error" class="col-lg-12 text-bold text-red"></div>
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                <div class="panel-footer">
                    
                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                   
                </div>

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
                    },
                    error:function(data){
                        alert('Something went wrong');
                        $('.disable_forward').show();
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
	$('input:radio[name=optrad]').change(function() {
        if (this.value == 'Y') {
			var myValue = $(".new_dag" ).val();
			var myOValue = $(".new_s_dag" ).val();
			$( ".show_dag" ).val(myValue);
        }
        else if (this.value == 'N') {
            var myValue = $(".new_dag" ).val();
            var myOValue = $(".new_s_dag" ).val();
            $( ".show_dag" ).val(myOValue);    
        }
    });
	

    $("#lm_submit").submit(function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Rtps/lm_submit_RTPS",
            type:'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (data) {
                $.unblockUI();
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
                    $('#div_error').html(data.errorMessage);
                }
            
                if(data.success == 'true'){
                    alert("Case has successfully forwarded for case no "+ data.case_no);
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
