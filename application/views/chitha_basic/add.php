<style>
.control-label11{
	font-size:1em !important;
	font-weight: normal !important;
	padding-top: 7px;
    margin-bottom: 0;
    text-align: right;
}
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
			<div class="panel panel-default panel-body ">
			<?php
			if($this->session->flashdata('message')):?>
				<p class='red uni_text'> <?=$this->session->flashdata('message')?> </p>
			<?php endif?>
			<center><h2 class='green'>Enter Dag Details</h2></center>
			<hr>
			 <form class="form-horizontal" role="form" action='<?= base_url();?>index.php/chitha_basic_deo/index' method="post">
				<div class="form-group hide">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dist Code</label>
					<div class="col-sm-2">
					  <input type="text"  name="dist_code" class="form-control districtselect" value="<?php echo $this->session->userdata('dist_code'); ?>" />
					  <?php echo form_error('dist_code');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Subdiv Code</label>
					<div class="col-sm-2">
					  <input type="text" name="subdiv_code" class="form-control subdivselect" value="<?php echo $this->session->userdata('subdiv_code'); ?>" />
					  <?php echo form_error('subdiv_code');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Cir Code</label>
					<div class="col-sm-2">
					  <input type="text" name="cir_code" class="form-control circleselect" value="<?php echo $this->session->userdata('cir_code'); ?>" />
					  <?php echo form_error('cir_code');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Mouza Pargona Code</label>
					<div class="col-sm-2">
					  <select class="form-control  mouzaselect" required name="mouza_pargona_code">
						<option>Select Mouza<option>
                        <?php foreach($mouzas as $d): ?>
								<option value='<?php echo $d->mouza_pargona_code; ?>'><?php echo $d->loc_name; ?></option>
                        <?php endforeach; ?>
					  </select>
					  <?php echo form_error('mouza_pargona_code');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Lot No</label>
					<div class="col-sm-2">
					    <select class="form-control  lotselect" id="select" required name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                        </select>
					<?php echo form_error('lot_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Vill Townprt Code</label>
					<div class="col-sm-2">
					  <select class="form-control  villageselect" id="select" required name="vill_townprt_code">
                            <option disabled selected>Select Village</option>
                      </select>
					  <?php echo form_error('vill_townprt_code');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2">Old Dag No</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="old_dag_no" value="<?php echo $this->input->post('old_dag_no'); ?>" />
					  <?php echo form_error('old_dag_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag No</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_no" value="<?php echo $this->input->post('dag_no'); ?>" />
					  <?php echo form_error('dag_no');?>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Patta Type Code</label>
					<div class="col-sm-2">
					  <select class="form-control" name="patta_type_code">
						<?php foreach($patta as $p): ?>
						<option value="<?php echo $p->type_code; ?>"><?=$p->patta_type;?></option>
						<?php endforeach; ?>
					  </select>
					  <?php echo form_error('patta_type_code');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Patta No</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="patta_no" value="<?php echo $this->input->post('patta_no'); ?>" />
					  <?php echo form_error('patta_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Land Class Code</label>
					<div class="col-sm-2">
						<select class="form-control" name="land_class_code">
						<option>Select Option</option>
						<?php foreach($landclass as $lc): ?>
						<option value="<?php echo $lc->class_code; ?>"><?=$lc->land_type;?></option>
						<?php endforeach; ?>
						</select>
					  <?php echo form_error('land_class_code');?>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area B</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_area_b" value="<?php echo $this->input->post('dag_area_b'); ?>" />
					  <?php echo form_error('dag_area_b');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area K</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_area_k" value="<?php echo $this->input->post('dag_area_k'); ?>" />
					  <?php echo form_error('dag_area_k');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area Lc</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_area_lc" value="<?php echo $this->input->post('dag_area_lc'); ?>" />
					  <?php echo form_error('dag_area_lc');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area G</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_area_g" value="<?php echo $this->input->post('dag_area_g'); ?>" />
					  <?php echo form_error('dag_area_g');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area Kr</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_area_kr" value="<?php echo $this->input->post('dag_area_kr'); ?>" />
					  <input type="hidden" class="form-control" name="dag_area_are" value="0.0" />
					  <?php echo form_error('dag_area_kr');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Revenue</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_revenue" value="<?php echo $this->input->post('dag_revenue'); ?>" />
					  <?php echo form_error('dag_revenue');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Local Tax</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_local_tax" value="<?php echo $this->input->post('dag_local_tax'); ?>" />
					  <?php echo form_error('dag_local_tax');?>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag N Desc</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="dag_n_desc" value="<?php echo $this->input->post('dag_n_desc'); ?>" />
					  <?php echo form_error('dag_n_desc');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag S Desc </label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="dag_s_desc" value="<?php echo $this->input->post('dag_s_desc'); ?>" />
					  <?php echo form_error('dag_s_desc');?>
					</div>
						
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag S Desc</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="dag_s_desc" value="<?php echo $this->input->post('dag_s_desc'); ?>" />
					  <?php echo form_error('dag_s_desc');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag E Desc </label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="dag_e_desc" value="<?php echo $this->input->post('dag_e_desc'); ?>" />
					  <?php echo form_error('dag_e_desc');?>
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag N Dag No</label>
					<div class="col-sm-1">
					  <input type="text" class="form-control" name="dag_n_dag_no" value="<?php echo $this->input->post('dag_n_dag_no'); ?>" />
					  <?php echo form_error('dag_n_dag_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag S Dag No </label>
					<div class="col-sm-1">
					  <input type="text" class="form-control" name="dag_s_dag_no" value="<?php echo $this->input->post('dag_s_dag_no'); ?>" />
					  <?php echo form_error('dag_s_dag_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag E Dag No</label>
					<div class="col-sm-1">
					  <input type="text" class="form-control" name="dag_e_dag_no" value="<?php echo $this->input->post('dag_e_dag_no'); ?>" />
					  <?php echo form_error('dag_e_dag_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Dag W Dag No </label>
					<div class="col-sm-1">
					  <input type="text" class="form-control" name="dag_w_dag_no" value="<?php echo $this->input->post('dag_w_dag_no'); ?>" />
					  <?php echo form_error('dag_w_dag_no');?>
					</div>	
				</div>
				<div class='hide'>
					<input type="text" name="operation" value="D" />
					<input type="text" name="jama_yn" value="n" />
					<input type="text" name="user_code" value="<?=$this->session->userdata('user_code')?>" />
					<input type="text" name="date_entry" value="<?php echo date('Y-m-d') ?>" />
					<input type="text" class="form-control" name="dag_w_dag_no" value="<?php echo $this->session->userdata('user_code'); ?>" />
				</div>
				
				<div class='hide'>
					Old Patta No : 
					<input type="text" name="old_patta_no" value="<?php echo $this->input->post('old_patta_no'); ?>" />
					<span class="text-danger"><?php echo form_error('old_patta_no');?></span>
				</div>
				<div class='hide'>
					Dag Name : 
					<input type="text" name="dag_name" value="<?php echo $this->input->post('dag_name'); ?>" />
					<span class="text-danger"><?php echo form_error('dag_name');?></span>
				</div>
				<div class='hide'>
					Dag Dept Name : 
					<input type="text" name="dag_dept_name" value="<?php echo $this->input->post('dag_dept_name'); ?>" />
					<span class="text-danger"><?php echo form_error('dag_dept_name');?></span>
				</div>
				
				<div class='hide'>
					Dag Area Are : 
					<input type="text" name="dag_area_are" value="<?php echo $this->input->post('dag_area_are'); ?>" />
					<span class="text-danger"><?php echo form_error('dag_area_are');?></span>
				</div>
				<center> <button class='btn btn-danger' type="submit"><i class='fa fa-save'></i> Save >> </button></center>
			<form>
			</div>
		</div>
	</div>
</div>