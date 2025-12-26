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
				<div class='col-lg-6'>
				<form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url()."index.php/Deletefromchitha/update_to_patta";?>">
					<table class='table table-stripped'>
						<thead>
							<tr>
								<td>Code</td>
								<td>Dag</td>
								<td>Patta - Code</td>
								<td>CDP-pflag</td>
								<td>CDP-PdarID</td>
							</tr>
						</thead>
                    <?php
					// var_dump($cdp);
					// var_dump($cp);
					foreach($cdp as $key=>$val){
						echo "<tr>";
						echo "<td>". $val->dist_code ."-". $val->subdiv_code."-". $val->cir_code ."-". $val->mouza_pargona_code."-". $val->lot_no ."-". $val->vill_townprt_code   ."</td>";
						echo "<td>". $val->dag_no ."</td>";
						echo "<td>". $val->patta_no ."-".$val->patta_type_code ."</td>";
						echo "<td>". $val->p_flag ."</td>";
						echo "<td>". $val->pdar_id ."</td>";
						echo "</tr>";
					}
					?>
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
						<input type='number' required='required' placeholder="If you want to change patta no..Type Here.." class='form-control' name='Update_patta' />
						<button type='submit' class='btn btn-xs btn-primary'>Submit</button>
					</div>
					</table>		
					</form>
                </div>
				<div class='col-lg-6'>
					<table class='table'>
						<thead>
						<tr>
							<td>CP-PdarID</td>
							<td>CP-Name</td>
							<td>CP-Father</td>
						</tr>
						</thead>
						<?php
						foreach($cp as $key=>$val){
							echo "<tr>";
							echo "<td>". $val->pdar_id ."</td>";
							echo "<td>". $val->pdar_name ."</td>";
							echo "<td>". $val->pdar_father ."</td>";
							echo "</tr>";
						}
						?>
					</table>
				</div>
                </div>
				
            </div>
        </div>
    </div> 
</div>
