<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12  panel panel-default panel-body ">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e"> Field Mutation Deleted/Dispose with specific date </h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">All cases Details</h3>
                </div>
                <div class="panel-body">
                    <table id="dataTable" class="display table" cellspacing="0" width="100%" >
						<thead class='active'>
							<tr>
								<th>Sl No</th>
								<th>Application Date</th>
								<th>Mutation No</th>
								<th>Circle Name</th>
								<th>Lot No</th>
								<th>Village Name</th>
								<th>Dispose Reason</th>
								<th>CO Name</th>
								<th>Dispose Date</th>
								
							</tr>
						</thead>
						<tbody>
						<?php $i=1;
						foreach($result as $value):
						?>
						<tr>
								<td><?=$i;?></td>
								<td><?=date('d/m/Y',strtotime($value->date_entry));?></td>
								<td><span class='red'><?=$value->case_no;?></span></td>
								<td><?=$this->utilityclass->getCircleName($value->dist_code,$value->subdiv_code,$value->cir_code)?></td>
								<td><?=$this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no)?></td>
								<td><?=$this->utilityclass->getVillageName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code)?></td>
								<td><span class='small'><?=$value->dispose_reason;?><span></td>
								<td><span class='green'><?php 
								$co=$this->utilityclass->getSelectedCOName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->add_off_name);
								echo $co->username;
								?></td>
								<td><?=date('d/m/Y',strtotime($value->if_dispose_date));?></td>
								
						</tr>
						<?php 
						$i++;
						endforeach;
						?>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    $('#dataTable').DataTable();
	});
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
    };
	
</script>