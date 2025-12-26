<div class="row login form-top">
    <div class="col-lg-10 col-lg-offset-1 ">
        <div class="panel panel-info panel-form">
		<div class="panel-heading">
                <center><h2 class="uni_text"> Khatian Basic Data Entry</h2></center>
		</div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-3  control-label required" >Khatian No</label>
                        <div class="col-sm-2">
                            <input type="number" readonly value='<?=$this->session->userdata['tenants']['khatian_no'];?>' name="id" class="form-control" />
							<?php echo form_error('id', '<p class="red form_error">', '</p>'); ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3  control-label required" >Dag No.</label>
                        <div class="col-sm-2">
							<select class="form-control" name='dag_no'>
								<option value=''>Select Option</option>
								<?php foreach($dags as $dag): ?>
								<option value='<?=$dag->dag_no_int;?>'><?=$dag->dag_no;?></option>
								<?php endforeach; ?>
							</select>
							<?php echo form_error('dag_no', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<hr style='border-bottom:2px solid #000;'>
					<center><p class='uni_text green'>Khatian Basic Entry</p></center>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 required  control-label " >Length of Possession</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Length of Possession' rows=3 name="length_posession"></textarea>
						<?php echo form_error('duration', '<p class="red form_error">', '</p>'); ?>
                        </div>
						<label for="inputEmail3" class="col-sm-2 required  control-label">Status of Tenant(s)</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Status of Tenant(s)' rows=2 name="tenant_status"></textarea>
						<?php echo form_error('tenant_status', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 required  control-label">Paid Cash Kind</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Paid Cash Kind' rows=3 name="paid_cash_kind"></textarea>
						<?php echo form_error('paid_cash_kind', '<p class="red form_error">', '</p>'); ?>
                        </div>
						<label for="inputEmail3" class="col-sm-2 required  control-label">Payable Cash/Kind</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Payable Cash/Kind' rows=3 name="payable_cash_kind"></textarea>
						<?php echo form_error('payable_cash_kind', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-3 required  control-label " id='applicant_name_label'>Special Conditions and incidence ,right of way casement etc.</label>
                        <div class="col-sm-9">
                        <textarea class="form-control" placeholder='Type Here' rows=3 name="special_conditions"></textarea>
						<?php echo form_error('special_conditions', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-3 required  control-label " >Remarks </label>
                        <div class="col-sm-9">
                        <textarea class="form-control" placeholder='Type Here' rows=3 name="remarks"></textarea>
						<?php echo form_error('remarks', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<hr>
                    <div class="form-group" style="width: 100%;text-align: center;">
                        <div class="">
                            <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?> </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>