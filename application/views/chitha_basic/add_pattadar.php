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
			<center><h2 class='green'>Enter Pattadar Details</h2></center>
			<hr>
			 <form class="form-horizontal" role="form" action='<?= base_url();?>index.php/chitha_basic_deo/add' method="post">
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Pdar Name :</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_name" value="<?php echo $this->input->post('pdar_name'); ?>" />
					  <?php echo form_error('pdar_name');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Pdar Father :</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_father" value="<?php echo $this->input->post('pdar_father'); ?>" />
					  <?php echo form_error('pdar_father');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Pdar Guard Reln</label>
					<div class="col-sm-2">
						<select class="form-control" name="pdar_guard_reln">
						<option>Select Relation</option>
						<?php foreach($relation as $p): ?>
						<option value="<?php echo $p->guard_rel; ?>"><?=$p->guard_rel_desc_as;?></option>
						<?php endforeach; ?>
					  </select>
					  <?php echo form_error('pdar_guard_reln');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2">Address 1</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_add1" value="<?php echo $this->input->post('pdar_add1'); ?>" />
					  <?php echo form_error('pdar_add1');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Address 2</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_add2" value="<?php echo $this->input->post('pdar_add2'); ?>" />
					  <?php echo form_error('pdar_add2');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Address 3</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_add3" value="<?php echo $this->input->post('pdar_add3'); ?>" />
					  <?php echo form_error('pdar_add3');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2">Pdar Pan No</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_pan_no" value="<?php echo $this->input->post('pdar_pan_no'); ?>" />
					  <?php echo form_error('pdar_pan_no');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>Pdar Minor Yn</label>
					<div class="col-sm-2">
					  <select class="form-control pdar_minor_yn"  name="pdar_minor_yn">
						<option>Select Option</option>
						<option value='y'> হয়</option>
						<option value='n'>নহয়</option>
					  </select>
					  <?php echo form_error('pdar_minor_yn');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>DOB</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control dob" id='popup1Datepicker' name="pdar_minor_dob" value="<?php echo $this->input->post('pdar_minor_dob'); ?>" />
					  <?php echo form_error('pdar_minor_dob');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2">Pdar Mobile</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_mobile" value="<?php echo $this->input->post('pdar_mobile'); ?>" />
					  <?php echo form_error('pdar_mobile');?>
					</div>
					<label class="control-label1 col-sm-2">Pdar Mother</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_mother" value="<?php echo $this->input->post('pdar_mother'); ?>" />
					  <?php echo form_error('pdar_mother');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span> Pdar Gender</label>
					<div class="col-sm-2">
					  <select class="form-control" name="pdar_gender">
						<option>Select Gender</option>
						<?php foreach($gender as $p): ?>
						<option value="<?php echo $p->short_name; ?>"><?=$p->gen_name_ass;?></option>
						<?php endforeach; ?>
					  </select>
					  <?php echo form_error('pdar_gender');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area B</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_por_b" value="<?php echo $this->input->post('dag_por_b'); ?>" />
					  <?php echo form_error('dag_por_b');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area K</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_por_k" value="<?php echo $this->input->post('dag_por_k'); ?>" />
					  <?php echo form_error('dag_por_k');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Dag Area Lc</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="dag_por_lc" value="<?php echo $this->input->post('dag_por_lc'); ?>" />
					  <?php echo form_error('dag_por_lc');?>
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
					  <?php echo form_error('dag_area_kr');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Pdar Revenue</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_land_revenue" value="<?php echo $this->input->post('pdar_land_revenue'); ?>" />
					  <?php echo form_error('pdar_land_revenue');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger">*</span>Pdar Local Tax</label>
					<div class="col-sm-2">
					  <input type="text" class="form-control" name="pdar_land_localtax" value="<?php echo $this->input->post('pdar_land_localtax'); ?>" />
					  <?php echo form_error('pdar_land_localtax');?>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>N Desc</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="pdar_land_n" value="<?php echo $this->input->post('pdar_land_n'); ?>" />
					  <?php echo form_error('pdar_land_n');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>S Desc </label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="pdar_land_s" value="<?php echo $this->input->post('pdar_land_s'); ?>" />
					  <?php echo form_error('pdar_land_s');?>
					</div>
						
				</div>
				<div class="form-group">
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>E Desc</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="pdar_land_e" value="<?php echo $this->input->post('pdar_land_e'); ?>" />
					  <?php echo form_error('pdar_land_e');?>
					</div>
					<label class="control-label1 col-sm-2"><span class="text-danger"></span>W Desc </label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" name="pdar_land_w" value="<?php echo $this->input->post('pdar_land_w'); ?>" />
					  <?php echo form_error('pdar_land_w');?>
					</div>	
				</div>
				<div class="hide">
					<div>
						<span class="text-danger">*</span>Dist Code : 
						<input type="text" name="dist_code" value="<?php echo $this->session->userdata['basic_entry']['dist_code']; ?>" />
						<span class="text-danger"><?php echo form_error('dist_code');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Subdiv Code : 
						<input type="text" name="subdiv_code" value="<?php echo $this->session->userdata['basic_entry']['subdiv_code']; ?>" />
						<span class="text-danger"><?php echo form_error('subdiv_code');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Cir Code : 
						<input type="text" name="cir_code" value="<?php echo $this->session->userdata['basic_entry']['cir_code'];?>" />
						<span class="text-danger"><?php echo form_error('cir_code');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Mouza Pargona Code : 
						<input type="text" name="mouza_pargona_code" value="<?php echo $this->session->userdata['basic_entry']['mouza_pargona_code'];?>" />
						<span class="text-danger"><?php echo form_error('mouza_pargona_code');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Lot No : 
						<input type="text" name="lot_no" value="<?php echo  $this->session->userdata['basic_entry']['lot_no']; ?>" />
						<span class="text-danger"><?php echo form_error('lot_no');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Vill Townprt Code : 
						<input type="text" name="vill_townprt_code" value="<?php echo  $this->session->userdata['basic_entry']['vill_townprt_code'];?>" />
						<span class="text-danger"><?php echo form_error('vill_townprt_code');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Patta No : 
						<input type="text" name="patta_no" value="<?php echo  $this->session->userdata['basic_entry']['patta_no']; ?>" />
						<span class="text-danger"><?php echo form_error('patta_no');?></span>
					</div>
					<div>
						<span class="text-danger">*</span>Patta Type Code : 
						<input type="text" name="patta_type_code" value="<?php echo  $this->session->userdata['basic_entry']['patta_type_code']; ?>" />
						<input type="text" name="dag_no" value="<?php echo  $this->session->userdata['basic_entry']['dag_no']; ?>" />
						<span class="text-danger"><?php echo form_error('patta_type_code');?></span>
					</div>
					<div class='hide'>
					<input type="text" name="operation" value="D" />
					<input type="text" name="jama_yn" value="n" />
					<input type="text" name="user_code" value="<?=$this->session->userdata('user_code')?>" />
					<input type="text" name="date_entry" value="<?php echo date('Y-m-d') ?>" />
					<input type="text" class="form-control" name="dag_w_dag_no" value="<?php echo $this->session->userdata('user_code'); ?>" />
					</div>
				</div>
				<center> <button class='btn btn-sm btn-danger' type="submit"><i class='fa fa-save'></i> Save</button></center>
			<form>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
    $(".pdar_minor_yn").change(function(){
		//alert($(this).val());
        if ( $(this).val() =='y' ) {
            $('.dob').prop('disabled', false);
        }if ( $(this).val() =='n' ) {
            $('.dob').prop('disabled', true);
        }
    });
});
</script>