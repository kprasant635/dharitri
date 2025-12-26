<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($data);?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
                <div class="panel panel-primary panel-form">
                <p class="text-center uni_text">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form')?>  </p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>:<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?>:<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-offset-3 btn btn-primary uni_text" id="jamabandiRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('jamabandi_for_patta');?></div>
                    <div class="btn btn-warning uni_text" id="PageRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('chitha_for_patta');?></div>
                </div>
                <hr>
                <p class="uni_text text-center">Total Land Area of a Particular Dag</p>
                <form class="form-inline" action="<?php echo base_url(); ?>index.php/CitizenController/LmStep4"  method="post">
                    <p id='showdata'  class="text-danger uni_text col-lg-offset-4" role="alert" ></p>
                    <div   style="margin-bottom: 15px; margin-top: 20px; margin-left: 100px">
                        <?php echo $this->lang->line('dag_no'); ?> : 
                        <select class="form-control dag_no_change" required="" id='dag_no_change' name='dag'>
                            <option><?php echo $this->lang->line('select_dag'); ?></option>
                            <?php foreach ($dags as $d): ?>
                                <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo $this->lang->line('bigha'); ?>: <input type="text" readonly="" class="form-control input-width"  id="appliedbigha"  value="0" />
                        <?php echo $this->lang->line('katha'); ?> : <input type="text" readonly=""  class="form-control input-width" id="appliedkatha"  value="0" /> 
                        <?php echo $this->lang->line('lesa'); ?>: <input type="text"  readonly="" class="form-control input-width" id="appliedlessa" value="0" /> 	
                    </div>
					<hr>
					<h4 class='red center uni_text'>Type Pattadar Land Portion Here :</h4>
					
					<div id="itemRows" class='center'>
					<label class="rasid">Dag : </label><label><input type="text" class="form-control" required name="dag[]" /></label>
                    <label class="rasid">Bigha : </label><label><input type="text" class="form-control" required name="bigha[]" /></label>
                    <label class="rasid">Ktha : </label><label><input type="text" class="form-control" required name="katha[]" /></label> 
                    <label class="rasid">Lessa : </label><label><input type="text" name="lessa[]" required class="form-control" /></label> 
                    <label class="rasid"><input onclick="addRow(this.form);" type="button" class="btn btn-info" value="Add More" /></label>
					<hr>
					</div>
					<span class='center uni_text'>Note :If there is more than one dag please click add more button</span>
					<hr>
					
                    <button style="margin-bottom: 10px; margin-top: 10px" class="btn btn-lg btn-success col-lg-offset-5" type="submit"> <?php echo $this->lang->line('submit_button');?></button>
                 </form>
                </div>
        </div>
    </div>
</div>