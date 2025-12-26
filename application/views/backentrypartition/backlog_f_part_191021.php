<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Backlog Entry for Partition (Field/Office)</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Please Fill Up the details below 
                        </h3>
                    </div>
                    <div class="panel-body">
						<?php echo validation_errors(); ?>
                        <form class="form-horizontal" method='post'>
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label">Please select the partition type</label>
                                <div class="col-lg-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="type"  value="1" checked=""> Field Partition
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="2" > Office Partition
                                    </label>
                                </div>
                            </div>
							<hr>
							<div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" readonly id="select" required name="mouza_code">
                                            <option value="<?php echo $datas['mouza_code']; ?>"><?php echo $datas['mouza_name']; ?></option>
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" readonly id="select" required name="lot_no">
                                        <option value="<?php echo $datas['lot_code']; ?>"><?php echo $datas['lot_no']; ?></option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label required"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>
										<?php foreach($vill as $v): ?>
										<option value="<?php echo $v->vill_townprt_code; ?>" ><?=$v->loc_name;?></option>
										<?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
								<label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-2">
                                 <select class="form-control pattatype_nmae"  required name="patta_type">
									<option>Select Patta Type</option>
                                    <?php
                                   foreach($pattatype as $p){
                                    ?>
                                       <option  value="<?php echo $p->type_code;?>"><?php echo $p->patta_type;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>	
                                </div>
								<label for="select" class="col-lg-2 required control-label">Old <?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-2">
									<select class="form-control pattanoselect" id="select" required name="patta_no">
                                    <option>Select Patta</option>
									</select>
									<?php echo form_error('patta_no'); ?>
                                </div>
                                <label for="select" class="col-lg-2 required control-label">Old <?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-2">
									<select class="form-control dag_no" id="select" required name="dag_no">
                                    <option>Select Dag</option>
									</select>
									<?php echo form_error('dag_no'); ?>
                                </div>    
                            </div>
                            <div class="form-group">
                                 <label class="col-lg-2 required control-label">New Dag No</label>
                                <div class="col-lg-2">
                                    <input class="form-control new_dag_no" placeholder="Enter New Dag No" autocomplete="off"  required name="new_dag_no" />
									<?php echo form_error('new_dag_no'); ?>
									<span class='success_message'></span>
								</div>
                                 <label class="col-lg-2 required control-label ">New Patta No </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" autocomplete="off"  required="" placeholder='Enter New patta No'  name="new_patta_no"   >
									<?php echo form_error('new_patta_no'); ?>
                                </div>
                            </div>
							<div class="form-group">
                                 <label for="select" class="col-lg-2 required control-label">Old <?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control" autocomplete="off" placeholder="Enter old Case Number"  required name="case_no" />
									<?php echo form_error('case_no'); ?>
                                </div>
                                 <label class="col-lg-3 required control-label uni_text">Date of order passed </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required="" autocomplete="off" placeholder='Date'  name="order_date"  class="form-control" >
									<?php echo form_error('order_date'); ?>
                                </div>
                            </div>
                            <hr>
                            <p class="center red bold"><u>Please Select the Name(s) who passed this order </u></p>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name') ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="lm_code">
                                    <?php
                                    foreach($lmname as $lm){
                                    ?>
                                       <option  value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup3Datepicker" required="" autocomplete="off" placeholder='Select Date'  name="lm_date"  class="form-control"  >
									<?php echo form_error('lm_date'); ?>
								</div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sk_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="sk_code">
                                    <?php
                                    foreach($skname as $sk){
                                    ?>
                                       <option  value="<?php echo $sk->user_code;?>"><?php echo $sk->username;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup2Datepicker" required="" autocomplete="off" placeholder='Select Date'  name="sk_date"  class="form-control"  >
									<?php echo form_error('sk_date'); ?>
								</div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name'); ?> </label>
                                <div class="col-lg-2">
                                     <select class="form-control"  required name="co_code">
                                    <?php
                                    foreach($coname as $co){
                                    ?>
                                       <option value="<?php echo $co->user_code;?>"><?php echo $co->username;?></option>
                                    <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" required="" placeholder='Select Date'  name="co_date" autocomplete="off"  class="form-control"  >
									<?php echo form_error('co_date'); ?>
								</div>
                            </div>
							</hr>
                            <h2 class="center red bold"><u>Land Area</u></h2>
                            <div class="form-group">
                                <p class="red bold"><u>Total Land Area</u></p>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" readonly id='b' name="t_bigha" placeholder='Bigha' required="" value="" >
									<?php echo form_error('t_bigha'); ?>
                                </div>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" readonly id='katha' name="t_katha" placeholder='Katha' required="" value="" >
									<?php echo form_error('t_katha'); ?>
                                </div>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" readonly id='l' name="t_lessa" placeholder='Lessa' required="" value="" >
									<?php echo form_error('t_lessa'); ?>
                                </div>  
                            </div>
							<div class="form-group">
                                <p class="red bold"><u>To be Partition Land Area</u></p>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_bigha" autocomplete="off" placeholder='Bigha' required="" value="" >
									<?php echo form_error('p_bigha'); ?>
                                </div>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_katha" autocomplete="off" placeholder='Katha' required="" value="" >
									<?php echo form_error('p_katha'); ?>
                                </div>
                                <label for="inputEmail" class="col-lg-2 required control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="p_lessa" autocomplete="off" placeholder='Lessa' required="" value="" >
									<?php echo form_error('p_lessa'); ?>
                                </div>  
                            </div>
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 required control-label uni_text">Revenue per bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" autocomplete="off" name="rev_p_bigha" placeholder='Revenue of New Dag' required="" value="" >
									<?php echo form_error('rev_p_bigha'); ?>
                                </div>
                            </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReport/";
    };
</script>
<script>
$(".new_dag_no").change(function(){
	var dist = $(".districtselect").val();
	var sub = $(".subdivselect").val();
	var cir = $(".circleselect").val();
	var mou = $(".mouzaselect").val();
	var lot = $(".lotselect").val();
	var vill = $(".villageselect").val();
	var new_dag_no = $(".new_dag_no").val();
		$.ajax({
            url: baseurl + "Backlogpartition/dagexist/" + dist + "/" + sub + "/" + cir + "/" + mou + "/" + lot + "/" + vill+ "/" + new_dag_no,
            success: function (data) {
                console.log(data);
				var returnedData =JSON.parse(data);
				if(returnedData['exist']==1){
					data="<p class='red'>Error !! Dag Number exists. Please enter non exist dag </p>";
				}else{
					data="<p class='green'> Success !! Dag Number not exists. </p>";
				}
				$('.success_message').fadeIn().html(data);
				setTimeout(function() {
					$('.success_message').fadeOut("slow");
				}, 4000 );
            }
		})
});
$(".dag_no").change(function(){
	var dist = $(".districtselect").val();
	var sub = $(".subdivselect").val();
	var cir = $(".circleselect").val();
	var mou = $(".mouzaselect").val();
	var lot = $(".lotselect").val();
	var vill = $(".villageselect").val();
	var dag_no = $(".dag_no").val();
		$.ajax({
            url: baseurl + "Backlogpartition/getLandArea/" + dist + "/" + sub + "/" + cir + "/" + mou + "/" + lot + "/" + vill+ "/" + dag_no,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                console.log(data);
                var dag = JSON.parse(data);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(dag[0].dag_area_lc);
                $('#g').val(dag[0].dag_area_g);
                $('#k').val(dag[0].dag_area_kr);
            }
		})
});
$(".pattanoselect").change(function(){
	var dist = $(".districtselect").val();
	var sub = $(".subdivselect").val();
	var cir = $(".circleselect").val();
	var mou = $(".mouzaselect").val();
	var lot = $(".lotselect").val();
	var vill = $(".villageselect").val();
	var pp = $(".pattatype_nmae").val();
	var pno = $(".pattanoselect").val();
		$.ajax({
            url: baseurl + "Backlogpartition/daglist/" + dist + "/" + sub + "/" + cir + "/" + mou + "/" + lot + "/" + vill+ "/" + pp + "/" + pno,
            success: function (data) {
				console.log(data);
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Dag Number</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].dag + "'>" + lot[i].dag + "</option>";
                }
                console.log(template);
                $('.dag_no').html(template);
            }
		})
});
</script>