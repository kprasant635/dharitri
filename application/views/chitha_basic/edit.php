<?php echo form_open('chitha_basic/edit/'.$chitha_basic['dag_no_int']); ?>

	<div>
		<span class="text-danger">*</span>Dist Code : 
		<input type="text" name="dist_code" value="<?php echo ($this->input->post('dist_code') ? $this->input->post('dist_code') : $chitha_basic['dist_code']); ?>" />
		<span class="text-danger"><?php echo form_error('dist_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Subdiv Code : 
		<input type="text" name="subdiv_code" value="<?php echo ($this->input->post('subdiv_code') ? $this->input->post('subdiv_code') : $chitha_basic['subdiv_code']); ?>" />
		<span class="text-danger"><?php echo form_error('subdiv_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Cir Code : 
		<input type="text" name="cir_code" value="<?php echo ($this->input->post('cir_code') ? $this->input->post('cir_code') : $chitha_basic['cir_code']); ?>" />
		<span class="text-danger"><?php echo form_error('cir_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Mouza Pargona Code : 
		<input type="text" name="mouza_pargona_code" value="<?php echo ($this->input->post('mouza_pargona_code') ? $this->input->post('mouza_pargona_code') : $chitha_basic['mouza_pargona_code']); ?>" />
		<span class="text-danger"><?php echo form_error('mouza_pargona_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Lot No : 
		<input type="text" name="lot_no" value="<?php echo ($this->input->post('lot_no') ? $this->input->post('lot_no') : $chitha_basic['lot_no']); ?>" />
		<span class="text-danger"><?php echo form_error('lot_no');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Vill Townprt Code : 
		<input type="text" name="vill_townprt_code" value="<?php echo ($this->input->post('vill_townprt_code') ? $this->input->post('vill_townprt_code') : $chitha_basic['vill_townprt_code']); ?>" />
		<span class="text-danger"><?php echo form_error('vill_townprt_code');?></span>
	</div>
	<div>
		Old Dag No : 
		<input type="text" name="old_dag_no" value="<?php echo ($this->input->post('old_dag_no') ? $this->input->post('old_dag_no') : $chitha_basic['old_dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('old_dag_no');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag No : 
		<input type="text" name="dag_no" value="<?php echo ($this->input->post('dag_no') ? $this->input->post('dag_no') : $chitha_basic['dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_no');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Patta Type Code : 
		<input type="text" name="patta_type_code" value="<?php echo ($this->input->post('patta_type_code') ? $this->input->post('patta_type_code') : $chitha_basic['patta_type_code']); ?>" />
		<span class="text-danger"><?php echo form_error('patta_type_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Patta No : 
		<input type="text" name="patta_no" value="<?php echo ($this->input->post('patta_no') ? $this->input->post('patta_no') : $chitha_basic['patta_no']); ?>" />
		<span class="text-danger"><?php echo form_error('patta_no');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Land Class Code : 
		<input type="text" name="land_class_code" value="<?php echo ($this->input->post('land_class_code') ? $this->input->post('land_class_code') : $chitha_basic['land_class_code']); ?>" />
		<span class="text-danger"><?php echo form_error('land_class_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag Area B : 
		<input type="text" name="dag_area_b" value="<?php echo ($this->input->post('dag_area_b') ? $this->input->post('dag_area_b') : $chitha_basic['dag_area_b']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_b');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag Area K : 
		<input type="text" name="dag_area_k" value="<?php echo ($this->input->post('dag_area_k') ? $this->input->post('dag_area_k') : $chitha_basic['dag_area_k']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_k');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag Area Lc : 
		<input type="text" name="dag_area_lc" value="<?php echo ($this->input->post('dag_area_lc') ? $this->input->post('dag_area_lc') : $chitha_basic['dag_area_lc']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_lc');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag Area G : 
		<input type="text" name="dag_area_g" value="<?php echo ($this->input->post('dag_area_g') ? $this->input->post('dag_area_g') : $chitha_basic['dag_area_g']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_g');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Dag Area Kr : 
		<input type="text" name="dag_area_kr" value="<?php echo ($this->input->post('dag_area_kr') ? $this->input->post('dag_area_kr') : $chitha_basic['dag_area_kr']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_kr');?></span>
	</div>
	<div>
		Dag Area Are : 
		<input type="text" name="dag_area_are" value="<?php echo ($this->input->post('dag_area_are') ? $this->input->post('dag_area_are') : $chitha_basic['dag_area_are']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_area_are');?></span>
	</div>
	<div>
		Dag Revenue : 
		<input type="text" name="dag_revenue" value="<?php echo ($this->input->post('dag_revenue') ? $this->input->post('dag_revenue') : $chitha_basic['dag_revenue']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_revenue');?></span>
	</div>
	<div>
		Dag Local Tax : 
		<input type="text" name="dag_local_tax" value="<?php echo ($this->input->post('dag_local_tax') ? $this->input->post('dag_local_tax') : $chitha_basic['dag_local_tax']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_local_tax');?></span>
	</div>
	<div>
		Dag No Map : 
		<input type="text" name="dag_no_map" value="<?php echo ($this->input->post('dag_no_map') ? $this->input->post('dag_no_map') : $chitha_basic['dag_no_map']); ?>" />
	</div>
	<div>
		Dag N Desc : 
		<input type="text" name="dag_n_desc" value="<?php echo ($this->input->post('dag_n_desc') ? $this->input->post('dag_n_desc') : $chitha_basic['dag_n_desc']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_n_desc');?></span>
	</div>
	<div>
		Dag S Desc : 
		<input type="text" name="dag_s_desc" value="<?php echo ($this->input->post('dag_s_desc') ? $this->input->post('dag_s_desc') : $chitha_basic['dag_s_desc']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_s_desc');?></span>
	</div>
	<div>
		Dag E Desc : 
		<input type="text" name="dag_e_desc" value="<?php echo ($this->input->post('dag_e_desc') ? $this->input->post('dag_e_desc') : $chitha_basic['dag_e_desc']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_e_desc');?></span>
	</div>
	<div>
		Dag W Desc : 
		<input type="text" name="dag_w_desc" value="<?php echo ($this->input->post('dag_w_desc') ? $this->input->post('dag_w_desc') : $chitha_basic['dag_w_desc']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_w_desc');?></span>
	</div>
	<div>
		Dag N Dag No : 
		<input type="text" name="dag_n_dag_no" value="<?php echo ($this->input->post('dag_n_dag_no') ? $this->input->post('dag_n_dag_no') : $chitha_basic['dag_n_dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_n_dag_no');?></span>
	</div>
	<div>
		Dag S Dag No : 
		<input type="text" name="dag_s_dag_no" value="<?php echo ($this->input->post('dag_s_dag_no') ? $this->input->post('dag_s_dag_no') : $chitha_basic['dag_s_dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_s_dag_no');?></span>
	</div>
	<div>
		Dag E Dag No : 
		<input type="text" name="dag_e_dag_no" value="<?php echo ($this->input->post('dag_e_dag_no') ? $this->input->post('dag_e_dag_no') : $chitha_basic['dag_e_dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_e_dag_no');?></span>
	</div>
	<div>
		Dag W Dag No : 
		<input type="text" name="dag_w_dag_no" value="<?php echo ($this->input->post('dag_w_dag_no') ? $this->input->post('dag_w_dag_no') : $chitha_basic['dag_w_dag_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_w_dag_no');?></span>
	</div>
	<div>
		Dag Nlrg No : 
		<input type="text" name="dag_nlrg_no" value="<?php echo ($this->input->post('dag_nlrg_no') ? $this->input->post('dag_nlrg_no') : $chitha_basic['dag_nlrg_no']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_nlrg_no');?></span>
	</div>
	<div>
		Dp Flag Yn : 
		<input type="text" name="dp_flag_yn" value="<?php echo ($this->input->post('dp_flag_yn') ? $this->input->post('dp_flag_yn') : $chitha_basic['dp_flag_yn']); ?>" />
		<span class="text-danger"><?php echo form_error('dp_flag_yn');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>User Code : 
		<input type="text" name="user_code" value="<?php echo ($this->input->post('user_code') ? $this->input->post('user_code') : $chitha_basic['user_code']); ?>" />
		<span class="text-danger"><?php echo form_error('user_code');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Date Entry : 
		<input type="text" name="date_entry" value="<?php echo ($this->input->post('date_entry') ? $this->input->post('date_entry') : $chitha_basic['date_entry']); ?>" />
		<span class="text-danger"><?php echo form_error('date_entry');?></span>
	</div>
	<div>
		<span class="text-danger">*</span>Operation : 
		<input type="text" name="operation" value="<?php echo ($this->input->post('operation') ? $this->input->post('operation') : $chitha_basic['operation']); ?>" />
		<span class="text-danger"><?php echo form_error('operation');?></span>
	</div>
	<div>
		Jama Yn : 
		<input type="text" name="jama_yn" value="<?php echo ($this->input->post('jama_yn') ? $this->input->post('jama_yn') : $chitha_basic['jama_yn']); ?>" />
		<span class="text-danger"><?php echo form_error('jama_yn');?></span>
	</div>
	<div>
		Status : 
		<input type="text" name="status" value="<?php echo ($this->input->post('status') ? $this->input->post('status') : $chitha_basic['status']); ?>" />
		<span class="text-danger"><?php echo form_error('status');?></span>
	</div>
	<div>
		Old Patta No : 
		<input type="text" name="old_patta_no" value="<?php echo ($this->input->post('old_patta_no') ? $this->input->post('old_patta_no') : $chitha_basic['old_patta_no']); ?>" />
		<span class="text-danger"><?php echo form_error('old_patta_no');?></span>
	</div>
	<div>
		Dag Name : 
		<input type="text" name="dag_name" value="<?php echo ($this->input->post('dag_name') ? $this->input->post('dag_name') : $chitha_basic['dag_name']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_name');?></span>
	</div>
	<div>
		Dag Dept Name : 
		<input type="text" name="dag_dept_name" value="<?php echo ($this->input->post('dag_dept_name') ? $this->input->post('dag_dept_name') : $chitha_basic['dag_dept_name']); ?>" />
		<span class="text-danger"><?php echo form_error('dag_dept_name');?></span>
	</div>
	
	<button type="submit">Save</button>
	
<?php echo form_close(); ?>