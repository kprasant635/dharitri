<div class="container-fluid form-top">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <?php
                //var_dump($location);
                ?>
                 <div class="panel-body">
                     <p class="uni_text center text-primary" style="margin-bottom: 35px">জমাবন্দীৰ নকল / মাটি থকাৰ / আয়ৰ / মাটিৰ মুল্যাংকন / নামজাৰী ওঁ অন্যান্য পত্রৰ বাবে আবেদন </p>
                     <p class="uni_text center" style="margin-bottom: 25px">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form');?></p>
                     <form class="form-horizontal unicode" action="<?php echo base_url();?>index.php/citizencontroller/Applicant" method="POST">
                         <div class="form-group">
                             <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('application_type');?> </label>
                             <div class="col-lg-3">
                                 <select class="form-control cert_code" name="cert_type">
                                     <option value="00"><?php echo  $this->lang->line('select_option');?></option>
                                     <?php foreach($certtype as $c): ?>
                                     <option value="<?php echo $c->cert_code."#".$c->cert_type.'#'.$c->delivery_time; ?>"><?php echo $c->cert_type; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 
                             </div>
                             <label for="inputEmail" class="col-lg-2 control-label"><?php echo  $this->lang->line('date');?> : </label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" readonly="" name="date_entry" value="<?php echo date('d/m/Y'); ?>"  >
                             </div>
                         </div>
                         <hr>
                         <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('district');?></label>
                            <div class="col-lg-4">
                                <select class="form-control districtselect" id="select" name="dist_code" required>
                                     <option value="<?php echo $d;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d);?>
                                    </option>
                                </select>
                            </div> 
                            <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('subdivision');?></label>
                            <div class="col-lg-4">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d,$subdiv_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('circle');?> </label>
                            <div class="col-lg-4">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                     <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                            <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('mouza');?>  </label>
                            <div class="col-lg-4">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach($mouzas as $d):?>
                                    <option value='<?php echo $d->mouza_pargona_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('lot_no');?> </label>
                            <div class="col-lg-4">
                                <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        <label for="select" class="col-lg-2 control-label"><?php echo  $this->lang->line('vill_town');?> </label>
                            <div class="col-lg-4">
                                <select class="form-control villageselect" id="select" required name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
                        
                         <hr>
                         <div class="form-group">
                             <label for="inputEmail" class="col-lg-2 control-label required"><?php echo  $this->lang->line('patta_type');?></label>
                             <div class="col-lg-4">
                                 <select class="form-control pattatype_nmae"  required name="patta_code">
                                    <option disabled selected><?php echo $this->lang->line('select_patta_type')?></option>
                                    <?php
                                    foreach ($patttype as $p):
                                        $type_code = $p->type_code;
                                        $patta_type = $p->patta_type;
                                        ?>
                                        <option value="<?php echo $type_code; ?>"><?php echo $patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                             </div>
                             
                             <label for="inputEmail" class="col-lg-2 control-label required"><?php echo  $this->lang->line('patta_no');?></label>
                             <div class="col-lg-4">
                                <select class="form-control pattanoselect" id="selectPatta" required name="patta_no">
                                    <option>Select Patta</option>
                                </select>
                             </div>
                         </div>
                         <div class="form-group">
                             <label for="inputEmail" class="col-lg-2 control-label">Service Fee.<?php //echo  $this->lang->line('revenue_amt');?></label>
                             <div class="col-lg-4 cert_fee">
                                 <input type="text" readonly="" class="form-control " name="cert_fees" >
                             </div>
							 <label for="inputEmail" class="col-lg-2 control-label">Case No.</label>
                             <div class="col-lg-4 case_no">
                                 <select class="form-control" id="mutCaseNo" required name="mutCaseNo">
                                    <option>Select Case No</option>
                                </select>
                             </div>
                         </div>
                         <div class="form-group">
                             <label for="inputEmail" class="col-lg-4 control-label"><?php echo  $this->lang->line('revenue_done');?></label>
                             <div class="col-lg-6">
                                 <label class="radio-inline">
                                     <input type="radio" name="revenue" checked=""  value="Y">  <?php echo  $this->lang->line('revenue_yes');?>
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" disabled="" name="revenue" value="N"> <?php echo  $this->lang->line('revenue_no');?>
                                  </label>
                             </div>
                         </div>
                        
                         <div class="form-group">
                            <?php if ($this->session->flashdata('message')): ?>
                            <?php 
                                echo '<div class="col-lg-12">
                                    <label style="color:red;">'.$this->session->flashdata('message').'</label>
                                </div>';
                            ?>
                            <?php endif; ?>
                            <div class="col-lg-10 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo  $this->lang->line('submit_button');?></button>
                                <button type="reset" class="btn btn-danger uni_text" id="openBtn"><i class="fa fa-reply"></i> <?php echo  $this->lang->line('previous_menu');?> </button>
                            </div>
                          </div>
                     </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
$(document).ready(function (e) {
	$(".pattanoselect").change(function(){
			var patta_no = $('.pattanoselect').val();
			var mouzacode = $('.mouzaselect').val();
			var lotcode = $('.lotselect').val();
			var villcode = $('.villageselect').val();
			var cer_code = $('.cert_code').val();
			var cer_code = cer_code.split('#');
			var cer_code = cer_code[0];
			console.log(cer_code);
			//alert(cer_code);
			//alert(patta_no);
			if (cer_code == '07')
			{
				$('#mutCaseNo').attr('disabled', false);
				console.log("Changer");
				$.ajax({
					url: baseurl + "citizencontroller/getAllMutCase/" + patta_no + "/" + mouzacode + "/" + lotcode + "/" + villcode,
					success: function (data) {
						console.log(data);
						//alert("da")
						var name = JSON.parse(data);
						var template = "<option selected disabled>Select Option</option>";
						for (var i = 0; i < name.length; i++) {
							template += "<option value='" + name[i].case_no + "'>" + name[i].case_no + "</option>";
						}
						console.log(template);
						$('#mutCaseNo').html(template);
					}
				});
			}else{
				$('#mutCaseNo').attr('disabled', true);
			}
	});
	$('#mutCaseNo').attr('disabled', 'disabled');
});

</script>
<!------------
SELECT * 
FROM petition_basic as pb INNER JOIN petition_dag_details as pd
ON pb.mut_type='03' and (pb.status= 'F' or pb.status=  'D') and pd.patta_no='1' order by pb.year_no
----------->