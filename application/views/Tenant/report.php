<style>
table tr td{ font-family: Serif; font-size:1.1em; color:#616060 !important }
</style>
<div class="row login form-top">
    <div class="col-lg-10 col-lg-offset-1 ">
        <div class="panel panel-info panel-form">
            <div class="panel-body">
				
				<table class='table table_black center'>
					<tr>
						<td><i class='fa fa-map-marker green'></i> Dist : <?=$this->utilityclass->getDistrictName($this->session->userdata['tenants']['dist_code']);?></td>
						<td><i class='fa fa-map-marker green'></i> Subdiv : <?=$this->utilityclass->getSubDivName($this->session->userdata['tenants']['dist_code'],$this->session->userdata['tenants']['subdiv_code']);?></td>
						<td><i class='fa fa-map-marker green'></i> Circle : <?=$this->utilityclass->getCircleName($this->session->userdata['tenants']['dist_code'],$this->session->userdata['tenants']['subdiv_code'],$this->session->userdata['tenants']['circle_code']);?></td>
					</tr>
					<tr>
						<td><i class='fa fa-map-marker green'></i> Mouza : <?=$this->utilityclass->getMouzaName($this->session->userdata['tenants']['dist_code'],$this->session->userdata['tenants']['subdiv_code'],$this->session->userdata['tenants']['circle_code'],$this->session->userdata['tenants']['mouza_code']);?></td>
						<td><i class='fa fa-map-marker green'></i> Lot No : <?=$this->utilityclass->getLotLocationName($this->session->userdata['tenants']['dist_code'],$this->session->userdata['tenants']['subdiv_code'],$this->session->userdata['tenants']['circle_code'],$this->session->userdata['tenants']['mouza_code'],$this->session->userdata['tenants']['lot_no']);?></td>
						<td><i class='fa fa-map-marker green'></i> Village/Town : <?=$this->utilityclass->getVillageName($this->session->userdata['tenants']['dist_code'],$this->session->userdata['tenants']['subdiv_code'],$this->session->userdata['tenants']['circle_code'],$this->session->userdata['tenants']['mouza_code'],$this->session->userdata['tenants']['lot_no'],$this->session->userdata['tenants']['vill_code']);?></td>
					</tr>
				</table>
				<h4 class='red'>Name of Tenant(s)</h4>
				
				<?php $name=$this->session->userdata('mut_petitioner');
					  foreach($name as $n):
				?>	
				<table class='table table_black'>
					<tr>
						<td><i class='fa fa-user'></i> Name : <?=$n['tenant_name'];?></td>
						<td><i class='fa fa-users'></i> Gurdian : <?=$n['tenants_father'];?></td>
						<td><i class='fa fa-plus'></i> Address : <?=$n['tenants_add1']."-".$n['tenants_add2'];?></td>
					</tr>
				</table>
				<?php endforeach;?>
				
				<h4 class='red'>Tenant(s) Possession</h4>
				
				<?php $basic=$this->session->userdata('tenant_basic');
					  foreach($basic as $b):
				?>
					<table class='table table_black'>
					<tr>
						<td>Posession Length: <?=$b['length_posession']?></td>
						<td>Tenant Status : <?=$b['tenant_status']?></td>
					</tr>
					<tr>
						<td>Paid Cash Kind: <?=$b['paid_cash_kind']?></td>
						<td>Payable Cash Kind : <?=$b['payable_cash_kind']?></td>
					</tr>
					
					<tr>
						<td colspan='2'>Special Condition : <?=$b['special_conditions']?></td>
					</tr>
					<tr>
						<td colspan='2'>Remarks : <?=$b['remarks']?></td>
					</tr>
					<tr>
						<td><i class='fa fa-list-ol red'></i> Dag Number: <?=$b['dag_no']/100?></td>
						<td><i class='fa fa-list-ol red'></i> Khatian Number : <?=$b['khatian_no']?></td>
					</tr>
					</table>
				<?php endforeach; ?>
				<form class="form-horizontal" action='<?php echo base_url()."index.php/Tenants/SaveAll" ?>' method="post">
				<center><button type='submit' class='btn btn-info'><i class='fa fa-check'></i> Confirm All Details</button>
				</center>
				</form>
				
			</div>
        </div>
    </div>
</div>