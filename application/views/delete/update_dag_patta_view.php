	<div class="row login">       
	    <div class="col-lg-12 ">
	        <div class="col-lg-12">
	            <?php if ($this->session->flashdata('message')): ?>
	                <?php include 'message.php'; ?>
	            <?php endif; ?>
	            <div class="well well-sm mis_report">
	                <h3 style="text-align: center; font-size: 28px">Check Chitha Dag-Patta pattadar Status</h3>
	                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
	            </div>                        
	            <div class="panel panel-form">
	                <div class="panel-body"> 
	                <div class='col-lg-12'>
						<table class='table'>
							<thead>
							<tr>
								<td>ID</td>
								<td>Owner Name</td>
								<td>Gurdian Father</td>
							</tr>
							</thead>
							<?php
							foreach($cp as $key=>$vall){
								echo "<tr>";
								echo "<td>". $vall->pdar_id ."</td>";
								echo "<td>". $vall->pdar_name ."</td>";
								echo "<td>". $vall->pdar_father ."</td>";
								echo "</tr>";
							}
							$val=$cdp;
							echo "<tr class='bg-primary'>";
							echo "<td>Location Code:". $val->dist_code ."-". $val->subdiv_code."-". $val->cir_code ."-". $val->mouza_pargona_code."-". $val->lot_no ."-". $val->vill_townprt_code   ."</td>";
							echo "<td>Dag No.". $val->dag_no ."</td>";
							echo "<td>Patta No.: ". $val->patta_no ." Type: ".$this->utilityclass->getPattaName($val->patta_type_code) ."</td>";
							echo "</tr>";
							?>

						</table>
					</div>
					<div class='col-lg-12'>
					<form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url()."index.php/JunkDagDelete/updateNewDagPatta";?>">
						<table class='table table-stripped'>
						<tr>
							<td>Patta No.<input type='number' readonly value="<?=$val->patta_no?>" required='required' placeholder="New Patta" class='form-control' name='update_patta' /></td>
							<td>New Dag<input type='number' required='required' placeholder="New Dag" class='form-control' name='update_dag' /></td>
							<td>Case No.<input type='text' required='required' placeholder="Case No" class='form-control' name='case_no' /></td>
						</tr>
						<tr>
							<td colspan="3">
								<button type='submit' class='btn btn-sm btn-primary'>Update Dag</button>
							</td>
						</tr>
						<div class='col-lg-5'>
							<input type='hidden' value='<?=$val->dist_code?>' name='dist_code' />
							<input type='hidden' value='<?=$val->subdiv_code?>' name='subdiv_code' />
							<input type='hidden' value='<?=$val->cir_code?>' name='cir_code' />
							<input type='hidden' value='<?=$val->mouza_pargona_code?>' name='mouza_pargona_code' />
							<input type='hidden' value='<?=$val->lot_no?>' name='lot_no' />
							<input type='hidden' value='<?=$val->vill_townprt_code?>' name='vill_townprt_code' />
							<input type='hidden' value='<?=$val->dag_no?>' name='dag_no' />
							<input type='hidden' value='<?=$val->patta_no?>' name='patta_no' />
							<input type='hidden' value='<?=$val->patta_type_code?>' name='patta_type_code' />
						</div>
						</table>		
						</form>
	                </div>
					
	                </div>
					
	            </div>
	        </div>
	    </div> 
	</div>
