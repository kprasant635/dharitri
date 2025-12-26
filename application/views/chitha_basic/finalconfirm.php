<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
		<?php //var_dump($this->session->all_userdata()); ?>
            <div class="col-lg-12 ">
                <div class="panel panel-info">
					<div class='row'>
						<div class='col-lg-10 col-lg-offset-1'>
							<h4 class='center uni_text'>All Entry Details</h4>
							<table class='table uni_text table_black'>
								<tr class='center'>
									<td>Dist : <?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'));?></td>
									<td>Subdiv :<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata['basic_entry']['subdiv_code']);?></td>
									<td>Circle :<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata['basic_entry']['subdiv_code'],$this->session->userdata['basic_entry']['cir_code']);?></td>
								</tr>
								<tr class='center'>
									<td>Mouza : <?=$this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata['basic_entry']['subdiv_code'],$this->session->userdata['basic_entry']['cir_code'],$this->session->userdata['basic_entry']['mouza_pargona_code']);?></td>
									<td>Lot No :<?=$this->utilityclass->getLotLocationName($this->session->userdata('dist_code'),$this->session->userdata['basic_entry']['subdiv_code'],$this->session->userdata['basic_entry']['cir_code'],$this->session->userdata['basic_entry']['mouza_pargona_code'],$this->session->userdata['basic_entry']['lot_no']);?></td>
									<td>Village : <?=$this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata['basic_entry']['subdiv_code'],$this->session->userdata['basic_entry']['cir_code'],$this->session->userdata['basic_entry']['mouza_pargona_code'],$this->session->userdata['basic_entry']['lot_no'],$this->session->userdata['basic_entry']['vill_townprt_code']);?></td>
								</tr>
							</table>
							<hr>
							<h4 class='center red'>Dag Details</h4>
							<?php //var_dump($this->session->userdata('basic'));?>
							<table class='table uni_text table_black'>
								<thead>
									<td>Dag No : <?=$this->session->userdata['basic_entry']['dag_no']?></td>
									<td>Patta No : <?=$this->session->userdata['basic_entry']['patta_no']?></td>
									<td>Patta Type : <?=$this->utilityclass->getPattaName($this->session->userdata['basic_entry']['patta_type_code'])?></td>
									<td>Land Class : <?=$this->utilityclass->getLandClassCode($this->session->userdata['basic_entry']['land_class_code'])?></td>
								</thead>
								<tr>
									<td>Bigha : <?=$this->session->userdata['basic_entry']['dag_area_b']?></td>
									<td>Katha : <?=$this->session->userdata['basic_entry']['dag_area_k']?></td>
									<td>Lessa : <?=$this->session->userdata['basic_entry']['dag_area_lc']?></td>
									<td>Gonda : <?=$this->session->userdata['basic_entry']['dag_area_g']?></td>
									<!---<td >Kranti : <?=$this->session->userdata['basic_entry']['dag_area_k']?></td> --->
								</tr>
								<tr>
									<td>Revenue : <?=$this->session->userdata['basic_entry']['dag_revenue']?></td>
									<td>Local Tax : <?=$this->session->userdata['basic_entry']['dag_local_tax']?></td>
									<td>Date : <?php echo date('d/m/Y')?></td>
									<td>User : <?=$this->session->userdata['basic_entry']['user_code']?></td>
									
								</tr>
							</table>
							<h4 class='center red'>Pattadar Details</h4>
							<table class='table uni_text table_black'>
								<?php
								$firstparty=$this->session->userdata('pattadar');
								foreach($firstparty as $fp):
								?>
								<thead>
									<td>Name <i class='fa fa-user'> :- <span class='red'><?=$fp['pdar_name'];?></span></td>
									<td>Gender <i class='fa fa-venus'>: <?=$fp['pdar_gender']?></td>
									<td>Mobile <i class='fa fa-mobile'></i>: <?=$fp['pdar_mobile']?></td>
								</thead>
								<tr>
									<td>Gurdian Name <i class='fa fa-user-plus'>: <?=$fp['pdar_father']?></td>
									<td colspan=2>Relation <i class='fa fa-retweet'>: <?=$this->utilityclass->get_relation($fp['pdar_guard_reln'])?></td>
								</tr>
								<tr>
									<td colspan=3 >Address <i class='fa fa-address-card'>: <?=$fp['pdar_add1'],$fp['pdar_add2'],$fp['pdar_add3']?></td>
								</tr>
								<?php endforeach; ?>
							</table>
							
							<center>
							<a class='btn btn-primary' href='<?php echo base_url();?>index.php/Chitha_basic_deo/FinalSubmit'> <i class=></i> Click Here to Confirm</a>
							</center>
							<br>
							<br>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>