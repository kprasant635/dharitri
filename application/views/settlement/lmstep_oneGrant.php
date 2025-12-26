<?php 

 $case_no = $this->session->userdata('case_no');

?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
             
               
			
                <form class="form-horizontal no-trigger" action="<?php echo base_url()."index.php/Settlement/lm_submitGrant" ?>" method="POST"  >              
                <div class='panel-body'>
				<br>
                    <h2 class="text-center" style="top:20px;">Report By Lot Mondal</h2>
					
					<h4 class="center hide red "><u>Schedule Of Land Settled</u></h4>
				
				<b><p>Case Number :<?php echo $case_no; ?></p></b>
				 <input type="hidden" class="form-control" value='<?php echo $case_no; ?>' name="caseno"  >
					
					
					<!--<div class="form-group ">    
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
					<!--<div class="form-group hide" >    
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
                                 
                    </div> !-->
				<!--	<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether under possesion of the applicant ? </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="Y" checked="">
                                        <?php //echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="N" >
                                        <?php //echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                    </div> !-->
					
					
					<!--<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Period of possesion since </label>
                                <div class="col-lg-2">
                                        <input type="text" name="p_year" value="" class="form-control " checked="" placeholder='Year'> From which Year
                                </div>
                                 
                    </div> !-->
					
					
				
				<!--	<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 required control-label ">Nature of Land Use </label>
								<div class="col-lg-3">
                                <select class='form-control required' name='land_use'>
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
                                 
                    </div> !-->
				
					<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 red control-label "> Dag Proposed </label>
								
								<div class="col-lg-2">
                                    <select class="form-control" multiple name="new_dag">
										<?php foreach($dag_patta as $d){ ?>
										<option><?php echo ($d->dag_no)/100; ?></option>
										<?php }?>
									</select>
                                </div>
								
                               
								<label for="inputEmail" class="col-lg-4 red control-label ">New Periodic Patta Proposed </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" value='<?php echo $new_patta; ?>' placeholder='Patta Number' name="new_patta" required="" value="" >
                                </div>
                    </div>
					<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 green control-label ">New Dag Patta Type </label>
                                <div class="col-lg-2">
									<select class="form-control" name="new_patta_type">
										<?php foreach($mutpatta as $np): ?>
										<option value='<?=$np->type_code?>'><?=$np->patta_type?></option>
										<?php endforeach; ?>
									</select>
                                    
                                </div>
							<!--	<label for="inputEmail" class="col-lg-4 green control-label ">New Dag Landclass Code </label>
                                <div class="col-lg-2">
									<select class="form-control" name="new_landcode">
										<?php //foreach($landsql as $np): ?>
										<option value='<?//=$np->class_code?>'><?//=$np->land_type?></option>
										<?php //endforeach; ?>
									</select>
                                   
                                </div>!-->
                    </div>
					
					<!--<div class="form-group">    
                                <label for="inputEmail" class="col-lg-3  control-label ">Check Existing Dag </label>
                                <div class="col-lg-2">
                                    <select class="form-control">
										<?php //foreach($dag_patta as $d){ ?>
										<option><?php //echo $d->dag_no; ?></option>
										<?php //}?>
									</select>
                                </div>
								<label for="inputEmail" class="col-lg-4 control-label ">Check Existing Patta</label>
                                <div class="col-lg-2">
                                    <select class="form-control">
										<?php //foreach($dag_patta as $d){ ?>
										<option><?php //echo $d->patta_no; ?></option>
										<?php //}?>
									</select>
                                </div>
                    </div> !-->
				<!--	<div class="form-group hide ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Existing TB Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_revenue" required value="" >
                                </div>
								<label for="inputEmail" class="col-lg-4 required control-label ">Existing Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="exist_local_tax" required value="" >
                                </div>
                    </div> !-->
					
					
					
					
					
				<!--	<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="revenue" id='P_land' required="" value="" >
                                </div>
								<label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" placeholder='Amount' name="local_tax" id='p_loc_tax' required="" value="" >
                                </div>
                    </div> !-->
					<?php //var_dump($mouzaname);?>
					<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                                <div class="col-lg-10">
                                   <!-- <textarea class="form-control" rows=10 placeholder='Type here' name="lm_comment" required="" value="" >আবেদনকাৰী য়ে <?php //echo $mouzaname?>মৌজাৰ <?php //echo $villname?> গাওৰ  <?php //echo $dag_details->dag_no; ?> নং দাগৰ  <?php //echo $dag_details->alot_area_b; ?> বিঘা <?php //echo $dag_details->alot_area_k; ?> কঠা <?php //echo $dag_details->alot_area_lc; ?> লেছা  মাটি  <?php //echo $dag_details->case_no; ?> নং আবন্টন পত্ৰযোগে লাভ কৰি  আবন্টন চত্ত অনুসৰি ভোগ দখল কৰি থকা দেখা যায় ৷ আবন্টত মাটি <?php //echo $villname?> গ্রাম্য এলেকাৰ ভিতৰত থকা জমী হয় । চৰকাৰী নিদ্দেশনা অনুযায়ী আবন্টত মাটিৰ পট্টন দিব পৰা যায় । </textarea> !-->
                               
                             <textarea class="form-control" rows=10 placeholder='Type here' name="lm_comment" required="" value="" ><?php echo $dist_name ?>  জিলাৰ উপায়ুক্ত মহোদয়ৰ <?php echo date('d/m/Y',strtotime($allotment_certificate123->date_of_issue)); ?> ইং তাৰিখৰ   <?php  echo $allotment_certificate123->certficate_no; ?> নং চিঠিৰ হকুমৰ্মে  <?php echo $patta_typ->patta_type ;?> <?php foreach($dag_patta as $d){ echo ($d->dag_no)/100; ?>,<?php  }?>  নং দাগ  নতুন  <?php echo $new_patta; ?>  নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰিব পাৰি। </textarea>
                       

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